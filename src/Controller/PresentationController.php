<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresentationController extends AbstractController
{
    #[Route('/fabienne', name: 'app_fabienne')]
    public function fabienne(): Response
    {
        return $this->render('presentation/fabienne.html.twig', [

        ]);
    }
}
