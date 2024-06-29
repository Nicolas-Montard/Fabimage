<?php

namespace App\Command;

use Symfony\Component\Mime\Email;
use App\Repository\TokenRepository;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
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

    public function __construct(TokenRepository $tokenRepository, MailerInterface $mailer, ParameterBagInterface $params)
    {
        parent::__construct();
        $this->tokenRepository = $tokenRepository;
        $this->mailer = $mailer;
        $this->params = $params;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTimeImmutable('now');
        foreach($this->tokenRepository->findAll() as $token){
            foreach($token->getBook()->getFollowUpEmails() as $email){
                $sendAfter = $email->getSendAfter();
                $createdAt = $token->getCreatedAt();
                $createdAtF = $token->getCreatedAt()->format('Y-m-d');
                if ($token->getEmail() && $now->diff($createdAt)->format('%a') == $now->diff($now->modify('-' . $sendAfter . 'days'))->format('%a')) {
                    $testData = [$now->diff($createdAt)->format('%a') > $now->diff($now->modify('-60 days'))->format('%a')];
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
                        ->to($this->params->get($token->getEmail()))
                        ->subject($subject)
                        ->htmlTemplate('book/afterBuyedBookEmail.html.twig')
                        ->context(['emailData' => $email, 'token' => $token]);
                    $maxAttempts = 5;
                    $attempts = 0;
                    while ($attempts < $maxAttempts) {
                        $emailNotSent = true;
                        try {
                            $this->mailer->send($email);
                            $emailNotSent = false;
                            break;
                        } catch (TransportExceptionInterface $e) {
                            $attempts++;
                        }
                    }
                } elseif ($now->diff($createdAt)->format('%a') > $now->diff($now->modify('-60 days'))->format('%a')) {
                    $this->tokenRepository->remove($token, true);
                }
            }
        }
        file_put_contents(dirname(__FILE__)."/logs.txt", "exec2");
        return Command::SUCCESS;
    }
}