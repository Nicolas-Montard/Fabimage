<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Token;
use App\Form\BookType;
use Stripe\StripeClient;
use App\Entity\BookEmail;
use App\Entity\PromotionalCode;
use Symfony\Component\Mime\Email;
use App\Repository\BookRepository;
use App\Repository\TokenRepository;
use Symfony\Component\Mailer\Mailer;
use App\Entity\FollowupemailHasToken;
use App\Repository\BookEmailRepository;
use Doctrine\ORM\EntityManagerInterface;

use function PHPUnit\Framework\throwException;
use function Symfony\Component\Clock\now;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\PromotionalCodeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FollowupemailHasTokenRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Psr\Cache\CacheItemPoolInterface as AdapterInterface;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/book')]
class BookController extends AbstractController
{
    private $manager;
    private $gateway;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;

        $this->gateway = new StripeClient($_ENV['STRIPE_SECRETKEY']);
    }

    #[Route('/', name: 'app_book_index')]
    public function index(BookRepository $bookRepository, Request $request): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
            'buyed' => $request->query->get('buyed'),
            'error' => $request->query->get('error'),
            'emailError' => $request->query->get('email')
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookRepository $bookRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get("descriptionFr")->getData() || !$form->get("descriptionEs")->getData() || !$form->get("descriptionEt")->getData() || !$form->get("emailFr")->getData() || !$form->get("emailEs")->getData() || !$form->get("emailEt")->getData()){
                return $this->redirectToRoute('app_book_new', ['error' => 1], Response::HTTP_SEE_OTHER);
            }
            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
            'error' => $request->query->get('error')
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, BookRepository $bookRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(BookType::class, $book, ['image_required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get("descriptionFr")->getData() || !$form->get("descriptionEs")->getData() || !$form->get("descriptionEt")->getData() || !$form->get("emailFr")->getData() || !$form->get("emailEs")->getData() || !$form->get("emailEt")->getData()){
                return $this->redirectToRoute('app_book_edit', ['error' => 1, 'id' => $book->getId()], Response::HTTP_SEE_OTHER);
            }
            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
            'error' => $request->query->get('error')
        ]);
    }

    #[Route('/delete/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, BookRepository $bookRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/checkout/{id}', name: 'app_checkout', methods: ['GET'])]
    public function checkout(Request $request, Book $book): Response
    {
        $sentCode = false;
        if (strlen($request->query->get('promotionalCode') > 0)){
            $sentCode = true;
            $promotionalCode = "";
            foreach ($book->getPromotionalCodes() as $code){
                if ($code->getName() == $request->query->get('promotionalCode')){
                    $promotionalCode = $code;
                    $price = $promotionalCode->getPrice();
                    if ($price == 0){
                        return $this->redirectToRoute('app_book_show', ['id' => $book->getId(), 'promoCode' => $promotionalCode->getName(), 'free' => true]);
                    }
                }
            }
            if ($promotionalCode == ""){
                return $this->redirectToRoute('app_book_show', ['wrongCode' => true, 'id' => $book->getId()]);
            }
        }
        if ($sentCode == false){
            $price = $book->getPrice();
        }
        $local = $request->getLocale();
        if ($local == 'fr'){
            $bookName = $book->getNameFr();
        } elseif($local == 'et'){
            $bookName = $book->getNameEt();
        } else{
            $bookName = $book->getNameEs();
        }
        $scheme = $request->getScheme();
        $checkout=$this->gateway->checkout->sessions->create(
            [
                'payment_method_types' => ['card'],
                'locale' => $local,
                'line_items'=>[[
                    'price_data'=>[
                        'currency'=> 'EUR',
                        'product_data'=>[
                            'name'=> $bookName,
                        ],
                        'unit_amount'=> $price,
                    ],
                    'quantity'=> 1
                ]],
                'mode'=> 'payment',
                'success_url'=> $scheme . "://" . $_SERVER['HTTP_HOST'] . "/" . $request->getLocale() .'/book/success/'. $book->getId() . '?id_sessions={CHECKOUT_SESSION_ID}',
                'cancel_url'=> $scheme . "://" . $_SERVER['HTTP_HOST'] . "/" . $request->getLocale() . '/book/cancel?id_sessions={CHECKOUT_SESSION_ID}',
            ]
        );
        return $this->redirect($checkout->url);
    }

    #[Route('/success/{id}', name: 'app_success')]
    public function success(Request $request, MailerInterface $mailer, Book $book, TokenRepository $tokenRepository, BookEmailRepository $bookEmailRepository, FollowupemailHasTokenRepository $followupemailHasTokenRepository): Response
    {
       $id_sessions=$request->query->get('id_sessions');
       $customer=$this->gateway->checkout->sessions->retrieve(
        $id_sessions,
        []
    );
       $customerEmail = $customer["customer_details"]["email"];
       $paymentStatus = $customer["payment_status"];
       $token = new Token();
       $token->setContent($id_sessions);
       $token->setCreatedAt(now());
       $token->setIsValid(true);
       $token->setBook($book);
       $token->setLanguage($request->getLocale());
       $token->setEmail($customerEmail);
       $tokenRepository->save($token, true);
       foreach ($book->getFollowUpEmails() as $followUpEmail) {
        $followupemailHasToken = new FollowupemailHasToken;
        $followupemailHasToken->setToken($token);
        $followupemailHasToken->setFollowUpEmail($followUpEmail);
        $followupemailHasTokenRepository->save($followupemailHasToken, true);
    }
       $local = $request->getLocale();
       if ($local == 'fr'){
           $subject = $book->getNameFr();
           $annex = $book->getAnnexFr();
       }elseif ($local == 'es'){
           $subject = $book->getNameEs();
           $annex = $book->getAnnexEs();
       }else{
           $subject = $book->getNameEt();
           $annex = $book->getAnnexEt();
       }
       $email = (new Email())
           ->from($this->getParameter('mailer_from'))
           ->to($customerEmail)
           ->subject($subject)
           ->html($this->renderView('book/buyedBookEmail.html.twig', ['token' => $id_sessions, 'lang' => $local, 'free' => 0, 'book' => $book]))
       ;
       if (
        $book->getAnnexFr() && $local == 'fr' ||
        $book->getAnnexEs() && $local == 'es' ||
        $book->getAnnexEt() && $local == 'et'
       ) {
        $email->attachFromPath(__DIR__ . '/../../private/uploads/annex/' . $annex);
       }
       $signer = new DkimSigner($this->getParameter('dkim_key'), 'fabimage.coach', 'symfony');
       $signedEmail = $signer->sign($email);
        try {
            $mailer->send($signedEmail);
        } catch (TransportExceptionInterface $e) {
            $bookEmail = new BookEmail();
            $bookEmail->setToken($token);
            $bookEmail->setType('customerBook');
            $bookEmail->setCreatedAt(new DateTimeImmutable());
            $bookEmailRepository->save($bookEmail, true);
            file_put_contents('errorLogBookCustomer', $e . " - " . date('Y-m-d H:i') . "\n", FILE_APPEND);
        }
       return $this->redirectToRoute('app_book_index', ['buyed' => 1]);
    }

    #[Route('/cancel', name: 'app_cancel', authority: 'admin.fabimage.coach')]
    public function cancel(Request $request): Response
    {
        return $this->redirectToRoute('app_book_index', ['error' => 1]);
    }

    #[Route('/downloadFree/{id}', name: 'app_download_free')]
    public function downloadFree(Request $request, TokenRepository $tokenRepository, Book $book, PromotionalCodeRepository $promotionalCodeRepository, MailerInterface $mailer, BookEmailRepository $bookEmailRepository, FollowupemailHasTokenRepository $followupemailHasTokenRepository): Response
    {
        if ($request->query->get('promoCode')){
            $promotionalCode = $promotionalCodeRepository->findOneBy(['name' => $request->query->get('promoCode'), 'Book' => $book]);
            if (!$promotionalCode){
                return $this->redirectToRoute('app_home');
            }
        }
        if ($book->getPrice() != 0){
            $this->redirectToRoute('app_home');
        }
        if (!filter_var($request->query->get('email', FILTER_VALIDATE_EMAIL))){
            return $this->redirectToRoute('app_book_index', ['wrongEmail' => true]);
        }
        $language = $request->getLocale();
        $tokenContent = bin2hex(random_bytes(15));
        $token = new Token();
        $token->setContent($tokenContent);
        $token->setCreatedAt(now());
        $token->setIsValid(true);
        $token->setBook($book);
        $token->setLanguage($language);
        $token->setEmail($request->query->get('email'));
        $token->setFirstName($request->query->get('firstName'));
        $tokenRepository->save($token, true);
        foreach ($book->getFollowUpEmails() as $followUpEmail) {
            $followupemailHasToken = new FollowupemailHasToken;
            $followupemailHasToken->setToken($token);
            $followupemailHasToken->setFollowUpEmail($followUpEmail);
            $followupemailHasTokenRepository->save($followupemailHasToken, true);
        }

        if ($language == 'fr'){
            $subject = $book->getNameFr();
            $annex = $book->getAnnexFr();
        }elseif ($language == 'es'){
            $subject = $book->getNameES();
            $annex = $book->getAnnexEs();
        }else{
            $subject = $book->getNameEt();
            $annex = $book->getAnnexEt();
        }
        $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to($request->query->get('email'))
            ->subject($subject)
            ->html($this->renderView('book/buyedBookEmail.html.twig', ['token' => $token->getContent(), 'lang' => $language, 'free' => 1, 'book' => $book]))
        ;
        if (
            $book->getAnnexFr() && $language == 'fr' ||
            $book->getAnnexEs() && $language == 'es' ||
            $book->getAnnexEt() && $language == 'et'
           ) {
            $email->attachFromPath(__DIR__ . '/../../private/uploads/annex/' . $annex);
           }
        $signer = new DkimSigner($this->getParameter('dkim_key'), 'fabimage.coach', 'symfony');
        $signedEmail = $signer->sign($email);
        try {
            $mailer->send($signedEmail);
        } catch (TransportExceptionInterface $e) {
            $bookEmail = new BookEmail();
            $bookEmail->setToken($token);
            $bookEmail->setType('customerBook');
            $bookEmail->setCreatedAt(new DateTimeImmutable());
            $bookEmailRepository->save($bookEmail, true);
            file_put_contents('errorLogBookCustomer', $e . " - " . date('Y-m-d H:i') . "\n", FILE_APPEND);
        }
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($this->getParameter('mailer_to'))
                ->subject($request->query->get('firstName') . ' a teléchargé ' . $subject)
                ->html($this->renderView('book/downloadBookEmail.html.twig', ['nom' => $request->query->get('name'), 'firstName' => $request->query->get('firstName'), 'mail' => $request->query->get('email'), 'book' => $subject]));
            $signer = new DkimSigner($this->getParameter('dkim_key'), 'fabimage.coach', 'symfony');
            $signedEmail = $signer->sign($email);
            try {
                $mailer->send($signedEmail);
            } catch (TransportExceptionInterface $e) {
                $bookEmail = new BookEmail();
                $bookEmail->setToken($token);
                $bookEmail->setType('adminBook');
                $bookEmail->setCreatedAt(new DateTimeImmutable());
                $bookEmailRepository->save($bookEmail, true);
                file_put_contents('errorLogBookAdmin', $e . " - " . date('Y-m-d H:i') . "/n", FILE_APPEND);
            }
        return $this->redirectToRoute('app_book_index', ['buyed' => 1]);
    }

    #[Route('/download', name: 'app_download', methods: ['GET'])]
    public function download(Request $request, TokenRepository $tokenRepository): Response
    {
        $tokenLink = $request->query->get('token');
        $token = $tokenRepository->findOneBy(['content' => $tokenLink]);
        if (!$token){
            $this->redirectToRoute('app_home');
        }
        $language = $token->getLanguage();
        if ($language == 'fr'){
            $book = $token->getBook()->getBookFr();
        } elseif($language == 'es'){
            $book = $token->getBook()->getBookEs();
        } else{
            $book = $token->getBook()->getBookEt();
        }
        $response = new BinaryFileResponse('../private/uploads/books/' . $book);
        return $response;
    }

    #[Route('/{id}', name: 'app_book_show')]
    public function show(Request $request, Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
            'buyed' => $request->query->get('buyed'),
            'error' => $request->query->get('error'),
            'emailError' => $request->query->get('email')
        ]);
    }
}
