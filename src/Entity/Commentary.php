<?php

namespace App\Entity;

use App\Repository\CommentaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaryRepository::class)]
class Commentary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentFr = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\ManyToOne(inversedBy: 'commentaries')]
    private ?Workshop $Workshop = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentFr(): ?string
    {
        return $this->contentFr;
    }

    public function setContentFr(string $content): static
    {
        $this->contentFr = $content;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getWorkshop(): ?workshop
    {
        return $this->Workshop;
    }

    public function setWorkshop(?workshop $workshop): static
    {
        $this->Workshop = $workshop;

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
}
