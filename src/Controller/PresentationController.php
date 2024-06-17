<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresentationController extends AbstractController
{
    #[Route('/imageCoaching', name: 'app_image_coaching')]
    public function coachingImage(): Response
    {
        return $this->render('presentation/coachingImage.html.twig', [

        ]);
    }

    #[Route('/fabienne', name: 'app_fabienne')]
    public function fabienne(): Response
    {
        return $this->render('presentation/fabienne.html.twig', [

        ]);
    }

    #[Route('/company', name: 'app_company')]
    public function company(): Response
    {
        return $this->render('presentation/company.html.twig', [

        ]);
    }
}
