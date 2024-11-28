<?php

namespace App\Controller;

use App\Entity\Marquee;
use App\Form\MarqueeType;
use App\Repository\MarqueeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/marquee')]
class MarqueeController extends AbstractController
{
    #[Route('/edit', name: 'app_marquee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MarqueeRepository $marqueeRepository, EntityManagerInterface $entityManager, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $marquee = $marqueeRepository->findOneBy([]);
        $form = $this->createForm(MarqueeType::class, $marquee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('marquee/edit.html.twig', [
            'marquee' => $marquee,
            'form' => $form,
        ]);
    }
    #[Route('/bar', name: 'app_marquee_bar')]
    public function marqueeBar(MarqueeRepository $marqueeRepository): Response
    {

        return $this->render('_include/_marquee.html.twig', [
            'marquee' => $marqueeRepository->findOneBy([]),
        ]);
    }

}
