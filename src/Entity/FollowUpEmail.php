<?php

namespace App\Entity;

use App\Repository\FollowUpEmailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowUpEmailRepository::class)]
class FollowUpEmail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentFr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentEs = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentEt = null;

    #[ORM\Column]
    private ?int $sendAfter = null;

    #[ORM\ManyToOne(inversedBy: 'followUpEmails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subjectFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subjectEs = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subjectEt = null;

    #[ORM\OneToMany(mappedBy: 'followUpEmail', targetEntity: FollowupemailHasToken::class, orphanRemoval: true)]
    private Collection $followupemailHasTokens;

    public function __construct()
    {
        $this->followupemailHasTokens = new ArrayCollection();
    }

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

    public function getSubjectFr(): ?string
    {
        return $this->subjectFr;
    }

    public function setSubjectFr(?string $subjectFr): static
    {
        $this->subjectFr = $subjectFr;

        return $this;
    }

    public function getSubjectEs(): ?string
    {
        return $this->subjectEs;
    }

    public function setSubjectEs(?string $subjectEs): static
    {
        $this->subjectEs = $subjectEs;

        return $this;
    }

    public function getSubjectEt(): ?string
    {
        return $this->subjectEt;
    }

    public function setSubjectEt(?string $subjectEt): static
    {
        $this->subjectEt = $subjectEt;

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
            $followupemailHasToken->setFollowUpEmail($this);
        }

        return $this;
    }

    public function removeFollowupemailHasToken(FollowupemailHasToken $followupemailHasToken): static
    {
        if ($this->followupemailHasTokens->removeElement($followupemailHasToken)) {
            // set the owning side to null (unless already changed)
            if ($followupemailHasToken->getFollowUpEmail() === $this) {
                $followupemailHasToken->setFollowUpEmail(null);
            }
        }

        return $this;
    }
}
