<?php

namespace App\Entity;

use App\Repository\FollowupemailHasTokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowupemailHasTokenRepository::class)]
class FollowupemailHasToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'followupemailHasTokens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FollowUpEmail $followUpEmail = null;

    #[ORM\ManyToOne(inversedBy: 'followupemailHasTokens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Token $token = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowUpEmail(): ?FollowUpEmail
    {
        return $this->followUpEmail;
    }

    public function setFollowUpEmail(?FollowUpEmail $followUpEmail): static
    {
        $this->followUpEmail = $followUpEmail;

        return $this;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }

    public function setToken(?Token $token): static
    {
        $this->token = $token;

        return $this;
    }
}
