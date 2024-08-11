<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[Vich\Uploadable]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titleFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize: '20M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;
    #[ORM\Column(type: Types::TEXT)]

    #[Assert\Length(
        max: 300
    )]
    private ?string $underTitleFr = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEs = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionEt = null;

    #[Assert\Length(
        max: 300
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $underTitleEs = null;

    #[Assert\Length(
        max: 300
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $underTitleEt = null;

    #[ORM\Column(nullable: true)]
    private ?int $priority = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescriptionFr(): ?string
    {
        return $this->descriptionFr;
    }

    public function setDescriptionFr(string $description): static
    {
        $this->descriptionFr = $description;

        return $this;
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

    public function getUnderTitleFr(): ?string
    {
        return $this->underTitleFr;
    }

    public function setUnderTitleFr(string $underTitle): static
    {
        $this->underTitleFr = $underTitle;

        return $this;
    }

    public function setPictureFile(File $image = null): Service
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

    public function getDescriptionEs(): ?string
    {
        return $this->descriptionEs;
    }

    public function setDescriptionEs(string $descriptionEs): static
    {
        $this->descriptionEs = $descriptionEs;

        return $this;
    }

    public function getDescriptionEt(): ?string
    {
        return $this->descriptionEt;
    }

    public function setDescriptionEt(string $descriptionEt): static
    {
        $this->descriptionEt = $descriptionEt;

        return $this;
    }

    public function getUnderTitleEs(): ?string
    {
        return $this->underTitleEs;
    }

    public function setUnderTitleEs(string $underTitleEs): static
    {
        $this->underTitleEs = $underTitleEs;

        return $this;
    }

    public function getUnderTitleEt(): ?string
    {
        return $this->underTitleEt;
    }

    public function setUnderTitleEt(string $underTitleEt): static
    {
        $this->underTitleEt = $underTitleEt;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }
}
