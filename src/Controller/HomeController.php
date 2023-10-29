<?php

namespace App\Controller;

use App\Repository\CommentaryHomeRepository;
use App\Repository\ServiceRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ServiceRepository $serviceRepository, CommentaryHomeRepository $commentaryHomeRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'services' => $serviceRepository->findAll(),
            'commentaries' => $commentaryHomeRepository->findAll(),
        ]);
    }
}
