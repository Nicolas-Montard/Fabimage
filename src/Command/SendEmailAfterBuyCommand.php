<?php

namespace App\Command;

use DateTime;
use Symfony\Component\Mime\Email;
use App\Repository\TokenRepository;
use App\Entity\FollowupemailHasToken;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Repository\FollowupemailHasTokenRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:sendEmailAfterBuy',
    description: 'Send an email 1 week after being buyed',
)]
class SendEmailAfterBuyCommand extends Command
{
    private TokenRepository $tokenRepository;
    private MailerInterface $mailer;
    private $params;
    private FollowupemailHasTokenRepository $followupemailHasTokenRepository;

    public function __construct(TokenRepository $tokenRepository, MailerInterface $mailer, ParameterBagInterface $params, FollowupemailHasTokenRepository $followupemailHasTokenRepository)
    {
        parent::__construct();
        $this->tokenRepository = $tokenRepository;
        $this->mailer = $mailer;
        $this->params = $params;
        $this->followupemailHasTokenRepository = $followupemailHasTokenRepository;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTimeImmutable('now');
        foreach($this->followupemailHasTokenRepository->findAll() as $followupemailHasToken){
            $email = $followupemailHasToken->getFollowUpEmail();
            $token = $followupemailHasToken->getToken();
            $sendAfter = $email->getSendAfter();
            $createdAt = $token->getCreatedAt();
            if ($token->getEmail() && $now->diff($createdAt)->format('%a') >= $now->diff($now->modify('-' . $sendAfter . 'days'))->format('%a')) {
                $lang = $token->getLanguage();
                if ($lang == 'fr') {
                    $subject = $email->getSubjectFr();
                } elseif ($lang == 'es') {
                    $subject = $email->getSubjectEs();
                } else {
                    $subject = $email->getSubjectEt();
                }
                $email = (new TemplatedEmail())
                    ->from($this->params->get('mailer_from'))
                    ->to($token->getEmail())
                    ->subject($subject)
                    ->htmlTemplate('book/afterBuyedBookEmail.html.twig')
                    ->context(['emailData' => $email, 'token' => $token]);
                $signer = new DkimSigner($this->params->get('dkim_key'), 'fabimage.coach', 'symfony');
                $signedEmail = $signer->sign($email);
                $this->mailer->send($signedEmail);
                $this->followupemailHasTokenRepository->remove($followupemailHasToken, true);
            }
        }
        return Command::SUCCESS;
    }
}