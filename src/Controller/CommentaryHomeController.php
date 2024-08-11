<?php

namespace App\Controller;

use App\Entity\CommentaryHome;
use App\Form\CommentaryHomeType;
use App\Repository\CommentaryHomeRepository;
use App\Repository\CommentaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

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
            if (!$form->get("contentFr")->getData() || !$form->get("contentEs")->getData() || !$form->get("contentEt")->getData()){
                return $this->redirectToRoute('app_commentary_home_new', ['error' => 1], Response::HTTP_SEE_OTHER);
            }
            $commentaryHomeRepository->save($commentaryHome, true);
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary_home/new.html.twig', [
            'commentary_home' => $commentaryHome,
            'form' => $form,
            'error' => $request->query->get('error')
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
            if (!$form->get("contentFr")->getData() || !$form->get("contentEs")->getData() || !$form->get("contentEt")->getData()){
                return $this->redirectToRoute('app_commentary_home_edit', ['error' => 1], Response::HTTP_SEE_OTHER);
            }
            $commentaryHomeRepository->save($commentaryHome, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary_home/edit.html.twig', [
            'commentary_home' => $commentaryHome,
            'form' => $form,
            'error' => $request->query->get('error')
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
    
    #[Route('/card', name: 'app_commentary_home_card', methods: ['POST'])]
    public function commentaryCard(CommentaryHomeRepository $commentaryHomeRepository): Response
    {

        return $this->render('_include/_card_commentary.html.twig', [
            'commentaries' => $commentaryHomeRepository->findAll(),
        ]);
    }
}
