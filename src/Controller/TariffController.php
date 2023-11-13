<?php

namespace App\Controller;

use App\Entity\Tariff;
use App\Form\TariffType;
use App\Repository\TariffRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tariff')]
class TariffController extends AbstractController
{
    #[Route('/', name: 'app_tariff_index', methods: ['GET'])]
    public function index(TariffRepository $tariffRepository): Response
    {
        return $this->render('tariff/index.html.twig', [
            'tariffs' => $tariffRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tariff_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TariffRepository $tariffRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $tariff = new Tariff();
        $form = $this->createForm(TariffType::class, $tariff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get("contentFr")->getData() || !$form->get("contentEs")->getData() || !$form->get("contentEt")->getData()){
                return $this->redirectToRoute('app_tariff_new', ['error' => 1], Response::HTTP_SEE_OTHER);
            }
            $tariffRepository->save($tariff, true);

            return $this->redirectToRoute('app_tariff_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tariff/new.html.twig', [
            'tariff' => $tariff,
            'form' => $form,
            'error' => $request->query->get('error')
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tariff_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tariff $tariff, TariffRepository $tariffRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(TariffType::class, $tariff, ['image_required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get("contentFr")->getData() || !$form->get("contentEs")->getData() || !$form->get("contentEt")->getData()){
                return $this->redirectToRoute('app_tariff_edit', ['error' => 1], Response::HTTP_SEE_OTHER);
            }
            $tariffRepository->save($tariff, true);
            return $this->redirectToRoute('app_tariff_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tariff/edit.html.twig', [
            'tariff' => $tariff,
            'form' => $form,
            'error' => $request->query->get('error')
        ]);
    }

    #[Route('/{id}', name: 'app_tariff_delete', methods: ['POST'])]
    public function delete(Request $request, Tariff $tariff, TariffRepository $tariffRepository, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete'.$tariff->getId(), $request->request->get('_token'))) {
            $tariffRepository->remove($tariff, true);
        }

        return $this->redirectToRoute('app_tariff_index', [], Response::HTTP_SEE_OTHER);
    }
}
