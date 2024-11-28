<?php

namespace App\Entity;

use App\Repository\MarqueeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueeRepository::class)]
class Marquee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contentFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contentEs = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contentEt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentFr(): ?string
    {
        return $this->contentFr;
    }

    public function setContentFr(?string $contentFr): static
    {
        $this->contentFr = $contentFr;

        return $this;
    }

    public function getContentEs(): ?string
    {
        return $this->contentEs;
    }

    public function setContentEs(?string $contentEs): static
    {
        $this->contentEs = $contentEs;

        return $this;
    }

    public function getContentEt(): ?string
    {
        return $this->contentEt;
    }

    public function setContentEt(?string $contentEt): static
    {
        $this->contentEt = $contentEt;

        return $this;
    }
}
