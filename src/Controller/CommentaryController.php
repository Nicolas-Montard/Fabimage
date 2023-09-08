<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Entity\Workshop;
use App\Form\CommentaryType;
use App\Repository\CommentaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/commentary')]
class CommentaryController extends AbstractController
{
    #[Route('/{id}', name: 'app_commentary_index', methods: ['GET'])]
    public function index(Workshop $workshop, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        return $this->render('commentary/index.html.twig', [
            'workshop' => $workshop,
        ]);
    }

    #[Route('/new/{id}', name: 'app_commentary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentaryRepository $commentaryRepository, Workshop $workshop, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $commentary = new Commentary();
        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentary->setWorkshop($workshop);
            $commentaryRepository->save($commentary, true);

            return $this->redirectToRoute('app_workshop_show', ['id' => $workshop->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary/new.html.twig', [
            'commentary' => $commentary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentary $commentary, CommentaryRepository $commentaryRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaryRepository->save($commentary, true);

            return $this->redirectToRoute('app_workshop_show', ['id'=>$commentary->getWorkshop()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary/edit.html.twig', [
            'commentary' => $commentary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentary_delete', methods: ['POST'])]
    public function delete(Request $request, Commentary $commentary, CommentaryRepository $commentaryRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete'.$commentary->getId(), $request->request->get('_token'))) {
            $commentaryRepository->remove($commentary, true);
        }

        return $this->redirectToRoute('app_workshop_show', ['id'=>$commentary->getWorkshop()->getId()], Response::HTTP_SEE_OTHER);
    }
}
