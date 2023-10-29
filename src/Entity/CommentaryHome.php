<?php

namespace App\Entity;

use App\Repository\CommentaryHomeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaryHomeRepository::class)]
class CommentaryHome
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titleFr = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEs = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEt = null;

    #[ORM\Column(length: 255)]
    private ?string $authorFr = null;

    #[ORM\Column(length: 255)]
    private ?string $authorEs = null;

    #[ORM\Column(length: 255)]
    private ?string $authorEt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleFr(): ?string
    {
        return $this->titleFr;
    }

    public function setTitleFr(string $titleFr): static
    {
        $this->titleFr = $titleFr;

        return $this;
    }

    public function getTitleEs(): ?string
    {
        return $this->titleEs;
    }

    public function setTitleEs(string $titleEs): static
    {
        $this->titleEs = $titleEs;

        return $this;
    }

    public function getTitleEt(): ?string
    {
        return $this->titleEt;
    }

    public function setTitleEt(string $titleEt): static
    {
        $this->titleEt = $titleEt;

        return $this;
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

    public function getAuthorFr(): ?string
    {
        return $this->authorFr;
    }

    public function setAuthorFr(string $authorFr): static
    {
        $this->authorFr = $authorFr;

        return $this;
    }

    public function getAuthorEs(): ?string
    {
        return $this->authorEs;
    }

    public function setAuthorEs(string $authorEs): static
    {
        $this->authorEs = $authorEs;

        return $this;
    }

    public function getAuthorEt(): ?string
    {
        return $this->authorEt;
    }

    public function setAuthorEt(string $authorEt): static
    {
        $this->authorEt = $authorEt;

        return $this;
    }
}
