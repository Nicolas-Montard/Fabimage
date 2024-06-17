<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\PromotionalCode;
use App\Form\PromotionalCodeType;
use App\Repository\PromotionalCodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/promotional/code')]
class PromotionalCodeController extends AbstractController
{
    #[Route('/{id}', name: 'app_promotional_code_index', methods: ['GET'])]
    public function index(PromotionalCodeRepository $promotionalCodeRepository, Book $book, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        return $this->render('promotional_code/index.html.twig', [
            'promotional_codes' => $book->getPromotionalCodes(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_promotional_code_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PromotionalCodeRepository $promotionalCodeRepository, Book $book, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $promotionalCode = new PromotionalCode();
        $form = $this->createForm(PromotionalCodeType::class, $promotionalCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotionalCode->setBook($book);
            $promotionalCodeRepository->save($promotionalCode, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotional_code/new.html.twig', [
            'promotional_code' => $promotionalCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_promotional_code_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PromotionalCode $promotionalCode, PromotionalCodeRepository $promotionalCodeRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(PromotionalCodeType::class, $promotionalCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotionalCodeRepository->save($promotionalCode, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotional_code/edit.html.twig', [
            'promotional_code' => $promotionalCode,
            'form' => $form,
            'book' => $promotionalCode->getBook(),
        ]);
    }

    #[Route('/{id}', name: 'app_promotional_code_delete', methods: ['POST'])]
    public function delete(Request $request, PromotionalCode $promotionalCode, PromotionalCodeRepository $promotionalCodeRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete'.$promotionalCode->getId(), $request->request->get('_token'))) {
            $promotionalCodeRepository->remove($promotionalCode, true);
        }

        return $this->redirectToRoute('app_promotional_code_index', ['id' => $promotionalCode->getBook()->getId()], Response::HTTP_SEE_OTHER);
    }
}
