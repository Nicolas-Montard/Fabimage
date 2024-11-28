<?php

namespace App\Controller;

use App\Form\ActualityType;
use App\Form\ServiceContactType;
use App\Form\WorkshopContactType;
use ReCaptcha\RequestMethod\Post;
use Symfony\Component\Mime\Email;
use function Symfony\Component\Clock\now;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
                $signer = new DkimSigner($this->getParameter('dkim_key'), 'fabimage.coach', 'symfony');
                $signedEmail = $signer->sign($email);
            try {
                $mailer->send($signedEmail);
            } catch (TransportExceptionInterface $e) {

            }
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
            $signer = new DkimSigner($this->getParameter('dkim_key'), 'fabimage.coach', 'symfony');
            $signedEmail = $signer->sign($email);
            try {
                $mailer->send($signedEmail);
            } catch (TransportExceptionInterface $e) {
            }
            $form = $this->createForm(ServiceContactType::class);
            return $this->redirectToRoute('contact_workshop', ['formSent' => true], Response::HTTP_SEE_OTHER);
        }
        return $this->render('contact/workshopContact.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/actuality', name: 'actuality')]
    public function actuality(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ActualityType::class, [
            'action' => $this->generateUrl('contact_actualityTreatment'),
        ]);
        return $this->render('_include/_actuality.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/actualityTreatment', name: 'actualityTreatment', methods: ['GET', 'POST'])]
    public function actualityTreatment(Request $request, MailerInterface $mailer): Response
    {
        $previousPage = ($request->headers->get('referer'));
        $previousPage .= '#actuality';
        $this->addFlash('actualitySent', 'true');
        $local = $request->getLocale();
        $form = $this->createForm(ActualityType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($this->getParameter('mailer_to'))
                ->subject($form->get('firstName')->getData() . ' souhaite s\'inscrire à la newsletter')
                ->html($this->renderView('contact/ActualityEmail.html.twig', ['form' => $formData, 'lang' => $local]));
            $signer = new DkimSigner($this->getParameter('dkim_key'), 'fabimage.coach', 'symfony');
            $signedEmail = $signer->sign($email);
            $mailer->send($signedEmail);
            $form = $this->createForm(ActualityType::class);
            return new RedirectResponse($previousPage, Response::HTTP_SEE_OTHER);
        }
        return $this->render('home/index.html.twig', [
            'form' => $form,
        ]);
    }

}
