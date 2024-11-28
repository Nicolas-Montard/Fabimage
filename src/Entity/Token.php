<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\ManyToOne(inversedBy: 'tokens')]
    private ?Book $Book = null;

    #[ORM\Column(length: 255)]
    private ?string $language = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\OneToMany(mappedBy: 'token', targetEntity: BookEmail::class)]
    private Collection $bookEmails;

    #[ORM\OneToMany(mappedBy: 'token', targetEntity: FollowupemailHasToken::class, orphanRemoval: true)]
    private Collection $followupemailHasTokens;

    public function __construct()
    {
        $this->bookEmails = new ArrayCollection();
        $this->followupemailHasTokens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): static
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->Book;
    }

    public function setBook(?Book $Book): static
    {
        $this->Book = $Book;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return Collection<int, BookEmail>
     */
    public function getBookEmails(): Collection
    {
        return $this->bookEmails;
    }

    public function addBookEmail(BookEmail $bookEmail): static
    {
        if (!$this->bookEmails->contains($bookEmail)) {
            $this->bookEmails->add($bookEmail);
            $bookEmail->setToken($this);
        }

        return $this;
    }

    public function removeBookEmail(BookEmail $bookEmail): static
    {
        if ($this->bookEmails->removeElement($bookEmail)) {
            // set the owning side to null (unless already changed)
            if ($bookEmail->getToken() === $this) {
                $bookEmail->setToken(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FollowupemailHasToken>
     */
    public function getFollowupemailHasTokens(): Collection
    {
        return $this->followupemailHasTokens;
    }

    public function addFollowupemailHasToken(FollowupemailHasToken $followupemailHasToken): static
    {
        if (!$this->followupemailHasTokens->contains($followupemailHasToken)) {
            $this->followupemailHasTokens->add($followupemailHasToken);
            $followupemailHasToken->setToken($this);
        }

        return $this;
    }

    public function removeFollowupemailHasToken(FollowupemailHasToken $followupemailHasToken): static
    {
        if ($this->followupemailHasTokens->removeElement($followupemailHasToken)) {
            // set the owning side to null (unless already changed)
            if ($followupemailHasToken->getToken() === $this) {
                $followupemailHasToken->setToken(null);
            }
        }

        return $this;
    }
}
