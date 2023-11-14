<?php

namespace App\Entity;

use App\Repository\BookRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameFr = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pictureFr = null;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'pictureFr')]
    #[Assert\File(
        maxSize: '20M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureFrFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pictureEs = null;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'pictureEs')]
    #[Assert\File(
        maxSize: '20M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureEsFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pictureEt = null;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'pictureEt')]
    #[Assert\File(
        maxSize: '20M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureEtFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookFr = null;

    #[Vich\UploadableField(mapping: 'book_file', fileNameProperty: 'bookFr')]
    #[Assert\File(
        maxSize: '100M',
        mimeTypes: ['application/pdf'],
    )]
    private ?File $bookFrFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookEs = null;

    #[Vich\UploadableField(mapping: 'book_file', fileNameProperty: 'bookEs')]
    #[Assert\File(
        maxSize: '100M',
        mimeTypes: ['application/pdf'],
    )]
    private ?File $bookEsFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookEt = null;

    #[Vich\UploadableField(mapping: 'book_file', fileNameProperty: 'bookEt')]
    #[Assert\File(
        maxSize: '100M',
        mimeTypes: ['application/pdf'],
    )]
    private ?File $bookEtFile = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionEt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $nameEs = null;

    #[ORM\Column(length: 255)]
    private ?string $nameEt = null;

    #[ORM\OneToMany(mappedBy: 'Book', targetEntity: Token::class, orphanRemoval: true)]
    private Collection $tokens;

    #[ORM\OneToMany(mappedBy: 'Book', targetEntity: PromotionalCode::class, orphanRemoval: true)]
    private Collection $promotionalCodes;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $smallDescriptionFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $smallDescriptionEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $smallDescriptionEt = null;

    public function __construct()
    {
        $this->tokens = new ArrayCollection();
        $this->promotionalCodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameFr(): ?string
    {
        return $this->nameFr;
    }

    public function setNameFr(string $name): static
    {
        $this->nameFr = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPictureFr(): ?string
    {
        return $this->pictureFr;
    }

    public function setPictureFr(?string $pictureFr): static
    {
        $this->pictureFr = $pictureFr;

        return $this;
    }

    public function getPictureEs(): ?string
    {
        return $this->pictureEs;
    }

    public function setPictureEs(?string $pictureEs): static
    {
        $this->pictureEs = $pictureEs;

        return $this;
    }

    public function getPictureEt(): ?string
    {
        return $this->pictureEt;
    }

    public function setPictureEt(?string $pictureEt): static
    {
        $this->pictureEt = $pictureEt;

        return $this;
    }

    public function getBookFr(): ?string
    {
        return $this->bookFr;
    }

    public function setBookFr(?string $bookFr): static
    {
        $this->bookFr = $bookFr;

        return $this;
    }

    public function getBookEs(): ?string
    {
        return $this->bookEs;
    }

    public function setBookEs(?string $bookEs): static
    {
        $this->bookEs = $bookEs;

        return $this;
    }

    public function getBookEt(): ?string
    {
        return $this->bookEt;
    }

    public function setBookEt(?string $bookEt): static
    {
        $this->bookEt = $bookEt;

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

    public function setPictureFrFile(File $image = null): Book
    {
        $this->pictureFrFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getPictureFrFile(): ?File
    {
        return $this->pictureFrFile;
    }

    public function setPictureEsFile(File $image = null): Book
    {
        $this->pictureEsFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getPictureEsFile(): ?File
    {
        return $this->pictureEsFile;
    }

    public function setPictureEtFile(File $image = null): Book
    {
        $this->pictureEtFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getPictureEtFile(): ?File
    {
        return $this->pictureEtFile;
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

    public function setBookFrFile(File $image = null): Book
    {
        $this->bookFrFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getBookFrFile(): ?File
    {
        return $this->bookFrFile;
    }

    public function setBookEsFile(File $image = null): Book
    {
        $this->bookEsFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getBookEsFile(): ?File
    {
        return $this->bookEsFile;
    }

    public function setBookEtFile(File $image = null): Book
    {
        $this->bookEtFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getBookEtFile(): ?File
    {
        return $this->bookEtFile;
    }

    public function getNameEs(): ?string
    {
        return $this->nameEs;
    }

    public function setNameEs(string $nameEs): static
    {
        $this->nameEs = $nameEs;

        return $this;
    }

    public function getNameEt(): ?string
    {
        return $this->nameEt;
    }

    public function setNameEt(string $nameEt): static
    {
        $this->nameEt = $nameEt;

        return $this;
    }

    /**
     * @return Collection<int, Token>
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function addToken(Token $token): static
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens->add($token);
            $token->setBook($this);
        }

        return $this;
    }

    public function removeToken(Token $token): static
    {
        if ($this->tokens->removeElement($token)) {
            // set the owning side to null (unless already changed)
            if ($token->getBook() === $this) {
                $token->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PromotionalCode>
     */
    public function getPromotionalCodes(): Collection
    {
        return $this->promotionalCodes;
    }

    public function addPromotionalCode(PromotionalCode $promotionalCode): static
    {
        if (!$this->promotionalCodes->contains($promotionalCode)) {
            $this->promotionalCodes->add($promotionalCode);
            $promotionalCode->setBook($this);
        }

        return $this;
    }

    public function removePromotionalCode(PromotionalCode $promotionalCode): static
    {
        if ($this->promotionalCodes->removeElement($promotionalCode)) {
            // set the owning side to null (unless already changed)
            if ($promotionalCode->getBook() === $this) {
                $promotionalCode->setBook(null);
            }
        }

        return $this;
    }

    public function getSmallDescriptionFr(): ?string
    {
        return $this->smallDescriptionFr;
    }

    public function setSmallDescriptionFr(string $smallDescriptionFr): static
    {
        $this->smallDescriptionFr = $smallDescriptionFr;

        return $this;
    }

    public function getSmallDescriptionEs(): ?string
    {
        return $this->smallDescriptionEs;
    }

    public function setSmallDescriptionEs(string $smallDescriptionEs): static
    {
        $this->smallDescriptionEs = $smallDescriptionEs;

        return $this;
    }

    public function getSmallDescriptionEt(): ?string
    {
        return $this->smallDescriptionEt;
    }

    public function setSmallDescriptionEt(string $smallDescriptionEt): static
    {
        $this->smallDescriptionEt = $smallDescriptionEt;

        return $this;
    }
}
