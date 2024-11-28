<?php

namespace App\Command;

use DateTime;
use Symfony\Component\Mime\Email;
use App\Repository\TokenRepository;
use App\Entity\FollowupemailHasToken;
use App\Repository\BookEmailRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Repository\FollowupemailHasTokenRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:sendBookEmail',
    description: 'Send the email for book',
)]
class SendBookEmailCommand extends Command
{
    private BookEmailRepository $bookEmailRepository;
    private MailerInterface $mailer;
    private $params;

    public function __construct(MailerInterface $mailer, ParameterBagInterface $params, BookEmailRepository $bookEmailRepository)
    {
        parent::__construct();
        $this->mailer = $mailer;
        $this->params = $params;
        $this->bookEmailRepository = $bookEmailRepository;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach($this->bookEmailRepository->findBy(['type' => 'customerBook']) as $bookEmail){
                $lang = $bookEmail->getToken()->getLanguage();
                $token = $bookEmail->getToken();
                $book = $token->getBook();
                $email = $token->getEmail();
                if ($lang == 'fr') {
                    $subject = $book->getNameFr();
                    $annex = $book->getAnnexFr();
                } elseif ($lang == 'es') {
                    $subject = $book->getNameEs();
                    $annex = $book->getAnnexEs();
                } else {
                    $subject = $book->getNameEt();
                    $annex = $book->getAnnexEt();
                }
                $mailToSend = (new TemplatedEmail())
                    ->from($this->params->get('mailer_from'))
                    ->to($email)
                    ->subject($subject)
                    ->htmlTemplate('book/buyedBookEmail.html.twig')
                    ->context(['token' => $token->getContent(), 'lang' => $lang, 'free' => 1, 'book' => $book]);
                if (
                    $book->getAnnexFr() && $lang == 'fr' ||
                    $book->getAnnexEs() && $lang == 'es' ||
                    $book->getAnnexEt() && $lang == 'et'
                    ) {
                    $mailToSend->attachFromPath(__DIR__ . '/../../private/uploads/annex/' . $annex);
                }
                $signer = new DkimSigner($this->params->get('dkim_key'), 'fabimage.coach', 'symfony');
                $signedEmail = $signer->sign($mailToSend);
                try {
                    $this->mailer->send($signedEmail);
                    $this->bookEmailRepository->remove($bookEmail, true);
                } catch (\Throwable $th) {
                    file_put_contents('errorLogBookCustomer', $th . " - " . date('Y-m-d H:i') . "\n", FILE_APPEND);
                }
            }
            foreach($this->bookEmailRepository->findBy(['type' => 'adminBook']) as $bookEmail){
                $lang = $bookEmail->getToken()->getLanguage();
                $token = $bookEmail->getToken();
                $book = $token->getBook();
                if ($lang == 'fr') {
                    $subject = $book->getNameFr();
                } elseif ($lang == 'es') {
                    $subject = $book->getNameEs();
                } else {
                    $subject = $book->getNameEt();
                }
                $mailToSend = (new TemplatedEmail())
                    ->from($this->params->get('mailer_from'))
                    ->to($this->params->get('mailer_to'))
                    ->subject($token->getFirstName() . ' a teléchargé ' . $subject)
                    ->htmlTemplate('book/downloadBookEmail.html.twig')
                    ->context(['firstName' => $token->getFirstName(), 'mail' => $token->getEmail(), 'book' => $subject]);
                    $signer = new DkimSigner($this->params->get('dkim_key'), 'fabimage.coach', 'symfony');
                    $signedEmail = $signer->sign($mailToSend);
                try {
                    $this->mailer->send($signedEmail);
                    $this->bookEmailRepository->remove($bookEmail, true);
                } catch (\Throwable $th) {
                    file_put_contents('errorLogBookAdminInWait', $th . " - " . date('Y-m-d H:i') . "\n", FILE_APPEND);
                }
            }
        return Command::SUCCESS;
    }
}