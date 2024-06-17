<?php

namespace App\Controller;

use App\Form\GiftCardType;
use App\Form\ServiceContactType;
use App\Form\WorkshopContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
#[Route('/giftCard', name: 'giftCard_')]
class GiftCardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(GiftCardType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($this->getParameter('mailer_to'))
                ->subject($form->get('name')->getData() . ' souhaite acheter une carte cadeau')
                ->html($this->renderView('giftCard/giftCardEmail.html.twig', ['form' => $formData]));
            $mailer->send($email);
            $form = $this->createForm(GiftCardType::class);
            return $this->redirectToRoute('giftCard_index', ['formSent' => true], Response::HTTP_SEE_OTHER);
        }
        return $this->render('giftCard/index.html.twig', [
            'form' => $form,
        ]);
    }
}
