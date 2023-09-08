<?php

namespace App\Entity;

use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use DateTimeInterface;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
#[Vich\Uploadable]
class Workshop
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $smallPicture = null;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'small_picture')]
    #[Assert\File(
        maxSize: '20M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $smallPictureFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;


    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    #[ORM\Column]
    private ?int $minNbPlaces = null;

    #[ORM\Column]
    private ?int $maxNbPlaces = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $optionalDescriptionFr = null;

    #[ORM\OneToMany(mappedBy: 'Workshop', targetEntity: Commentary::class, orphanRemoval: true)]
    private Collection $commentaries;

    #[ORM\Column(length: 255)]
    private ?string $titleEs = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionEt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $optionalDescriptionEs = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $optionalDescriptionEt = null;

    public function __construct()
    {
        $this->commentaries = new ArrayCollection();
    }

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

    public function getDescriptionFr(): ?string
    {
        return $this->descriptionFr;
    }

    public function setDescriptionFr(string $descriptionFr): static
    {
        $this->descriptionFr = $descriptionFr;

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

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getMinNbPlaces(): ?int
    {
        return $this->minNbPlaces;
    }

    public function setMinNbPlaces(int $minNbPlaces): static
    {
        $this->minNbPlaces = $minNbPlaces;

        return $this;
    }

    public function getMaxNbPlaces(): ?int
    {
        return $this->maxNbPlaces;
    }

    public function setMaxNbPlaces(int $maxNbPlaces): static
    {
        $this->maxNbPlaces = $maxNbPlaces;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getOptionalDescriptionFr(): ?string
    {
        return $this->optionalDescriptionFr;
    }

    public function setOptionalDescriptionFr(?string $optionalDescriptionFr): static
    {
        $this->optionalDescriptionFr = $optionalDescriptionFr;

        return $this;
    }

    /**
     * @return Collection<int, Commentary>
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentary $commentary): static
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries->add($commentary);
            $commentary->setWorkshop($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): static
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getWorkshop() === $this) {
                $commentary->setWorkshop(null);
            }
        }

        return $this;
    }

    public function setPictureFile(File $image = null): Workshop
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
    /**
     * @return File|null
     */
    public function getSmallPictureFile(): ?File
    {
        return $this->smallPictureFile;
    }

    /**
     * @param File|null $smallPictureFile
     */
    public function setSmallPictureFile(File $image = null): Workshop
    {
        $this->smallPictureFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSmallPicture(): ?string
    {
        return $this->smallPicture;
    }

    /**
     * @param string|null $smallPicture
     */
    public function setSmallPicture(?string $smallPicture): static
    {
        $this->smallPicture = $smallPicture;

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

    public function getOptionalDescriptionEs(): ?string
    {
        return $this->optionalDescriptionEs;
    }

    public function setOptionalDescriptionEs(?string $optionalDescriptionEs): static
    {
        $this->optionalDescriptionEs = $optionalDescriptionEs;

        return $this;
    }

    public function getOptionalDescriptionEt(): ?string
    {
        return $this->optionalDescriptionEt;
    }

    public function setOptionalDescriptionEt(?string $optionalDescriptionEt): static
    {
        $this->optionalDescriptionEt = $optionalDescriptionEt;

        return $this;
    }

}
