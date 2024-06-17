<?php

namespace App\Entity;

use App\Repository\TariffRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTime;

#[ORM\Entity(repositoryClass: TariffRepository::class)]
#[Vich\Uploadable]
class Tariff
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize: '20M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureFile = null;

    #[ORM\Column(length: 255)]
    private ?string $titleFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentFr = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEs = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getTitleFr(): ?string
    {
        return $this->titleFr;
    }

    public function setTitleFr(string $title): static
    {
        $this->titleFr = $title;

        return $this;
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

    public function setPictureFile(File $image = null): Tariff
    {
        $this->pictureFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
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
