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
            if ($token->getEmail() && $now->diff($token->getCreatedAt())->d > $now->diff($now->modify('-7 days'))->d && $token->getBook()->getFollowUpEmailFr() && $token->getBook()->getFollowUpEmailEs() && $token->getBook()->getFollowUpEmailEt() ) {
                $lang = $token->getLanguage();
                if ($lang == 'fr') {
                    $subject = 'Qu\'avez-vous pensé du livre électronique ?';
                } elseif ($lang == 'es') {
                    $subject = '¿Qué te ha parecido el e-Book?';
                } else {
                    $subject = 'Mida sa e-raamatust arvad?';
                }
                $email = (new TemplatedEmail())
                    ->from($this->params->get('mailer_from'))
                    ->to($this->params->get('mailer_to'))
                    ->subject($subject)
                    ->htmlTemplate('book/afterBuyedBookEmail.html.twig')
                    ->context(['token' => $token]);
                $maxAttempts = 5;
                $attempts = 0;
                while ($attempts < $maxAttempts) {
                    $emailNotSent = true;
                    try {
                        $this->mailer->send($email);
                        $emailNotSent = false;
                        $this->tokenRepository->remove($token, true);
                        break;
                    } catch (TransportExceptionInterface $e) {
                        $attempts++;
                    }
                }
            } elseif (!$token->getEmail() && $now->diff($token->getCreatedAt())->d > $now->diff($now->modify('-7 days'))->d) {
                $this->tokenRepository->remove($token, true);
            }
        }
        file_put_contents(dirname(__FILE__)."/logs.txt", "exec2");
        return Command::SUCCESS;
    }
}