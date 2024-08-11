<?php

namespace App\Controller;

use App\Form\ActualityType;
use Symfony\Component\Mime\Email;
use App\Repository\ServiceRepository;
use App\Repository\WorkshopRepository;
use App\Repository\CommentaryHomeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ServiceRepository $serviceRepository, CommentaryHomeRepository $commentaryHomeRepository,): Response
    {
        
        return $this->render('home/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }
}
