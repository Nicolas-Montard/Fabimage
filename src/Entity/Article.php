<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use DateTime;
use DateTimeInterface;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titleFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $summaryFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentFr = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEs = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $summaryEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEt = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize: '20M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureFile = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $summaryEt = null;

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

    public function getSummaryFr(): ?string
    {
        return $this->summaryFr;
    }

    public function setSummaryFr(string $summaryFr): static
    {
        $this->summaryFr = $summaryFr;

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

    public function getSummaryEs(): ?string
    {
        return $this->summaryEs;
    }

    public function setSummaryEs(string $summaryEs): static
    {
        $this->summaryEs = $summaryEs;

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

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

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

    public function setPictureFile(File $image = null): Article
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSummaryEt(): ?string
    {
        return $this->summaryEt;
    }

    public function setSummaryEt(string $summaryEt): static
    {
        $this->summaryEt = $summaryEt;

        return $this;
    }
}
