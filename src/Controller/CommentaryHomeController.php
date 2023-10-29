<?php

namespace App\Controller;

use App\Entity\CommentaryHome;
use App\Form\CommentaryHomeType;
use App\Repository\CommentaryHomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commentary/home')]
class CommentaryHomeController extends AbstractController
{

    #[Route('/new', name: 'app_commentary_home_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentaryHomeRepository $commentaryHomeRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $commentaryHome = new CommentaryHome();
        $form = $this->createForm(CommentaryHomeType::class, $commentaryHome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaryHomeRepository->save($commentaryHome, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary_home/new.html.twig', [
            'commentary_home' => $commentaryHome,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentary_home_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CommentaryHome $commentaryHome, CommentaryHomeRepository $commentaryHomeRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(CommentaryHomeType::class, $commentaryHome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaryHomeRepository->save($commentaryHome, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary_home/edit.html.twig', [
            'commentary_home' => $commentaryHome,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentary_home_delete', methods: ['POST'])]
    public function delete(Request $request, CommentaryHome $commentaryHome, CommentaryHomeRepository $commentaryHomeRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete'.$commentaryHome->getId(), $request->request->get('_token'))) {
            $commentaryHomeRepository->remove($commentaryHome, true);
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
