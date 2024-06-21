<?php

namespace App\Entity;

use App\Repository\FollowUpEmailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowUpEmailRepository::class)]
class FollowUpEmail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEt = null;

    #[ORM\Column]
    private ?int $sendAfter = null;

    #[ORM\ManyToOne(inversedBy: 'followUpEmails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentFr(): ?string
    {
        return $this->contentFr;
    }

    public function setContentFr(string $contentFr): static
    {
        $this->contentFr = $contentFr;

        return $this;
    }

    public function getContentEs(): ?string
    {
        return $this->contentEs;
    }

    public function setContentEs(string $contentEs): static
    {
        $this->contentEs = $contentEs;

        return $this;
    }

    public function getContentEt(): ?string
    {
        return $this->contentEt;
    }

    public function setContentEt(string $contentEt): static
    {
        $this->contentEt = $contentEt;

        return $this;
    }

    public function getSendAfter(): ?int
    {
        return $this->sendAfter;
    }

    public function setSendAfter(int $sendAfter): static
    {
        $this->sendAfter = $sendAfter;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }
}
