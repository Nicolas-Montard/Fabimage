<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\FollowUpEmail;
use App\Form\FollowUpEmailType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FollowUpEmailRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/followUpEmail')]
class FollowUpEmailController extends AbstractController
{
    #[Route('/{id}', name: 'app_follow_up_email_index', methods: ['GET'])]
    public function index(Book $book, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        return $this->render('follow_up_email/index.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/new/{id}', name: 'app_follow_up_email_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security, Book $book, SessionInterface $session): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $followUpEmail = new FollowUpEmail();
        $form = $this->createForm(FollowUpEmailType::class, $followUpEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get("contentFr")->getData() || !$form->get("contentEs")->getData() || !$form->get("contentEt")->getData()){
                $session->set('form_data', $request->request->all()['follow_up_email']);
                return $this->redirectToRoute('app_follow_up_email_new', ['error' => 1, 'id' => $book->getId()], Response::HTTP_SEE_OTHER);
            }
            $followUpEmail->setBook($book);
            $entityManager->persist($followUpEmail);
            $entityManager->flush();

            return $this->redirectToRoute('app_follow_up_email_index', ['id' => $book->getId()], Response::HTTP_SEE_OTHER);
        }
        $formData = $session->get('form_data', []);
        $session->remove('form_data');
        $form->submit($formData);
        return $this->render('follow_up_email/new.html.twig', [
            'follow_up_email' => $followUpEmail,
            'form' => $form,
            'error' => $request->query->get('error')
        ]);
    }

    #[Route('/edit/{id}', name: 'app_follow_up_email_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FollowUpEmail $followUpEmail, EntityManagerInterface $entityManager, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(FollowUpEmailType::class, $followUpEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get("contentFr")->getData() || !$form->get("contentEs")->getData() || !$form->get("contentEt")->getData()){
                return $this->redirectToRoute('app_follow_up_email_edit', ['error' => 1, 'id' => $followUpEmail->getId()], Response::HTTP_SEE_OTHER);
            }
            $entityManager->persist($followUpEmail);
            $entityManager->flush();

            return $this->redirectToRoute('app_follow_up_email_index', ['id' => $followUpEmail->getBook()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('follow_up_email/edit.html.twig', [
            'follow_up_email' => $followUpEmail,
            'form' => $form,
            'error' => $request->query->get('error')
        ]);
    }

    #[Route('/{id}', name: 'app_follow_up_email_delete', methods: ['POST'])]
    public function delete(Request $request, FollowUpEmail $followUpEmail, EntityManagerInterface $entityManager, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $book = $followUpEmail->getBook();
        if ($this->isCsrfTokenValid('delete'.$followUpEmail->getId(), $request->request->get('_token'))) {
            $entityManager->remove($followUpEmail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_follow_up_email_index', ['id' => $book->getId()], Response::HTTP_SEE_OTHER);
    }
}
