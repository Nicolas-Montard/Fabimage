<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    private $manager;
    private $gateway;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;

        $this->gateway = new StripeClient($_ENV['STRIPE_SECRETKEY']);
    }

    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(BookType::class, $book, ['image_required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/checkout/{id}', name: 'app_checkout', methods: ['GET'])]
    public function checkout(Request $request, Book $book): Response
    {
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
                'line_items'=>[[
                    'price_data'=>[
                        'currency'=> 'EUR',
                        'product_data'=>[
                            'name'=> $bookName,
                        ],
                        'unit_amount'=> $book->getPrice(),
                    ],
                    'quantity'=> 1
                ]],
                'mode'=> 'payment',
                'success_url'=> 'http://localhost:8000/'. $request->getLocale() .'/book/success/'. $book->getId() . '?id_sessions={CHECKOUT_SESSION_ID}',
                'cancel_url'=> 'http://localhost:8000/'. $request->getLocale() .'/book/cancel?id_sessions={CHECKOUT_SESSION_ID}',
            ]
        );
        return $this->redirect($checkout->url);
    }

    #[Route('/success/{id}', name: 'app_success')]
    public function success(Request $request, MailerInterface $mailer, Book $book): Response
    {
       $id_sessions=$request->query->get('id_sessions');
       $customer=$this->gateway->checkout->sessions->retrieve(
           $id_sessions,
           []
       );

       $customerEmail = $customer["customer_details"]["email"];
       $paymentStatus = $customer["payment_status"];
       $local = $request->getLocale();
       if ($local == 'fr'){
           $subject = 'Achat de votre livre';
           $bookPath = 'http://localhost:8000/private/uploads/books/' . $book->getBookFr();
       }elseif ($local == 'es'){
           $subject = 'Compra tu libro';
           $bookPath = 'http://localhost:8000/private/uploads/books/' . $book->getBookEs();
       }else{
           $subject = 'Ostke oma raamat';
           $bookPath = 'http://localhost:8000/private/uploads/books/' . $book->getBookEt();
       }

       $email = (new Email())
           ->from($this->getParameter('mailer_from'))
           ->to($customerEmail)
           ->subject($subject)
           ->html($this->renderView('book/buyedBookEmail.html.twig'));

       $mailer->send($email);

       return $this->redirectToRoute('app_book_index');
    }

    #[Route('/cancel', name: 'app_cancel')]
    public function cancel(Request $request): Response
    {
        return $this->redirectToRoute('app_book_index');
    }

}
