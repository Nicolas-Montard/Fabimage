<?php

namespace App\Command;

use App\Repository\TokenRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:removeExpiredToken',
    description: 'Remove token older than 6 month',
)]
class RemoveExpiredTokenCommand extends Command
{
    private TokenRepository $tokenRepository;
    private $params;

    public function __construct(TokenRepository $tokenRepository, ParameterBagInterface $params)
    {
        parent::__construct();
        $this->tokenRepository = $tokenRepository;
        $this->params = $params;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTimeImmutable('now');
        foreach ($this->tokenRepository->findAll() as $token) {
            $createdAt = $token->getCreatedAt();
            if ($now->diff($createdAt)->format('%a') > $now->diff($now->modify('-60 days'))->format('%a'))
            {
                $this->tokenRepository->remove($token, true);
            }
        }
        return Command::SUCCESS;
    }
}