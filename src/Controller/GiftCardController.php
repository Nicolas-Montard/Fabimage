<?php

namespace App\Controller;

use App\Form\GiftCardType;
use App\Form\ServiceContactType;
use App\Form\WorkshopContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            $signer = new DkimSigner($this->getParameter('dkim_key'), 'fabimage.coach', 'symfony');
            $signedEmail = $signer->sign($email);
            $mailer->send($signedEmail);
            $form = $this->createForm(GiftCardType::class);
            return $this->redirectToRoute('giftCard_index', ['formSent' => true], Response::HTTP_SEE_OTHER);
        }
        return $this->render('giftCard/index.html.twig', [
            'form' => $form,
        ]);
    }
}
