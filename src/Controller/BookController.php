<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\PromotionalCode;
use App\Entity\Token;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\PromotionalCodeRepository;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Clock\now;

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
            if (!$form->get("descriptionFr")->getData() || !$form->get("descriptionEs")->getData() || !$form->get("descriptionEt")->getData() || !$form->get("FollowUpEmailFr")->getData() || !$form->get("FollowUpEmailEs")->getData() || !$form->get("FollowUpEmailEt")->getData() || !$form->get("emailFr")->getData() || !$form->get("emailEs")->getData() || !$form->get("emailEt")->getData()){
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
            if (!$form->get("descriptionFr")->getData() || !$form->get("descriptionEs")->getData() || !$form->get("descriptionEt")->getData() || !$form->get("FollowUpEmailFr")->getData() || !$form->get("FollowUpEmailEs")->getData() || !$form->get("FollowUpEmailEt")->getData() || !$form->get("emailFr")->getData() || !$form->get("emailEs")->getData() || !$form->get("emailEt")->getData()){
                return $this->redirectToRoute('app_book_new', ['error' => 1], Response::HTTP_SEE_OTHER);
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
                'success_url'=> "https://" . $_SERVER['HTTP_HOST'] . "/" . $request->getLocale() .'/book/success/'. $book->getId() . '?id_sessions={CHECKOUT_SESSION_ID}',
                'cancel_url'=> "https://" . $_SERVER['HTTP_HOST'] . "/" . $request->getLocale() . '/book/cancel?id_sessions={CHECKOUT_SESSION_ID}',
            ]
        );
        return $this->redirect($checkout->url);
    }

    #[Route('/success/{id}', name: 'app_success')]
    public function success(Request $request, MailerInterface $mailer, Book $book, TokenRepository $tokenRepository): Response
    {
       $id_sessions=$request->query->get('id_sessions');
       $token = new Token();
       $token->setContent($id_sessions);
       $token->setCreatedAt(now());
       $token->setIsValid(true);
       $token->setBook($book);
       $token->setLanguage($request->getLocale());
       $token->setEmail($request->query->get('email'));
       $tokenRepository->save($token, true);
       $customer=$this->gateway->checkout->sessions->retrieve(
           $id_sessions,
           []
       );
       $customerEmail = $customer["customer_details"]["email"];
       $paymentStatus = $customer["payment_status"];
       $local = $request->getLocale();
       if ($local == 'fr'){
           $subject = $book->getNameFr();
       }elseif ($local == 'es'){
           $subject = $book->getNameEs();
       }else{
           $subject = $book->getNameEt();
       }
       $email = (new Email())
           ->from($this->getParameter('mailer_from'))
           ->to($customerEmail)
           ->subject($subject)
           ->html($this->renderView('book/buyedBookEmail.html.twig', ['token' => $id_sessions, 'lang' => ucfirst($local), 'free' => 0, 'book' => $book]))
       ;
        $maxAttempts = 3;
        $attempts = 0;
        while ($attempts < $maxAttempts) {
            $emailNotSent = true;
            try {
                $mailer->send($email);
                $emailNotSent = false;
                break;
            } catch (TransportExceptionInterface $e) {
                $attempts++;
            }
        }
       return $this->redirectToRoute('app_book_index', ['buyed' => 1]);
    }

    #[Route('/cancel', name: 'app_cancel')]
    public function cancel(Request $request): Response
    {
        return $this->redirectToRoute('app_book_index', ['error' => 1]);
    }

    #[Route('/downloadFree/{id}', name: 'app_download_free')]
    public function downloadFree(Request $request, TokenRepository $tokenRepository, Book $book, PromotionalCodeRepository $promotionalCodeRepository, MailerInterface $mailer): Response
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
        $tokenRepository->save($token, true);
        if ($language == 'fr'){
            $subject = $book->getNameFr();
        }elseif ($language == 'es'){
            $subject = $book->getNameES();
        }else{
            $subject = $book->getNameEt();
        }
        $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to($request->query->get('email'))
            ->subject($subject)
            ->html($this->renderView('book/buyedBookEmail.html.twig', ['token' => $token->getContent(), 'lang' => ucfirst($language), 'free' => 1, 'book' => $book]))
        ;
        $maxAttempts = 3;
        $attempts = 0;
        while ($attempts < $maxAttempts) {
            $emailNotSent = true;
            try {
                $mailer->send($email);
                $emailNotSent = false;
                break;
            } catch (TransportExceptionInterface $e) {
                $attempts++;
            }
        }
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($this->getParameter('mailer_to'))
                ->subject($request->query->get('firstName') . " " . $request->query->get('name') . ' a telechargé ' . $subject)
                ->html($this->renderView('book/downloadBookEmail.html.twig', ['nom' => $request->query->get('name'), 'firstName' => $request->query->get('firstName'), 'email' => $request->query->get('email'), 'book' => $subject]));
            $maxAttempts = 3;
            $attempts = 0;
            while ($attempts < $maxAttempts) {
                $emailNotSent = true;
                try {
                    $mailer->send($email);
                    $emailNotSent = false;
                    break;
                } catch (TransportExceptionInterface $e) {
                    $attempts++;
                }
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
