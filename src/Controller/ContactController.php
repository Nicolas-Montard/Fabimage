<?php

namespace App\Controller;

use App\Form\ServiceContactType;
use App\Form\WorkshopContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use function Symfony\Component\Clock\now;

#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'service')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ServiceContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($this->getParameter('mailer_to'))
                ->subject($form->get('firstName')->getData() . ' ' . $form->get('lastName')->getData() .
                    ' Vous a envoyé une ' . $form->get('type')->getData())
                ->html($this->renderView('contact/serviceContactEmail.html.twig', ['form' => $formData]));
            $mailer->send($email);
            $form = $this->createForm(ServiceContactType::class);
            return $this->redirectToRoute('contact_service', ['formSent' => true], Response::HTTP_SEE_OTHER);
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/workshop', name: 'workshop')]
    public function workshop(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(WorkshopContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($this->getParameter('mailer_to'))
                ->subject($form->get('firstName')->getData() . ' ' . $form->get('lastName')->getData() .
                    ' vous contacte pour un atelier')
                ->html($this->renderView('contact/workshopContactEmail.html.twig', ['form' => $formData]));
            $mailer->send($email);
            $form = $this->createForm(ServiceContactType::class);
            return $this->redirectToRoute('contact_workshop', ['formSent' => true], Response::HTTP_SEE_OTHER);
        }
        return $this->render('contact/workshopContact.html.twig', [
            'form' => $form,
        ]);
    }
}
