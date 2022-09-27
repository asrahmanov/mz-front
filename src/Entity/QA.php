<?php

namespace App\Entity;

use App\Repository\QARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QARepository::class)
 */
class QA
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $questionText;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $answerText;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class, inversedBy="qAs")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $answerAuthor;

    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authorName;

    /**
     * @ORM\ManyToMany(targetEntity=Branch::class, inversedBy="qAs")
     */
    private $branches;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $authorEmail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublicationAllowed;

    public function __construct()
    {
        $this->setCreatedAt((new \DateTime)->setTime(0, 0, 0));
        $this->branches = new ArrayCollection();
        $this->isPublished = false;
        $this->isPublicationAllowed = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): self
    {
        $this->questionText = $questionText;

        return $this;
    }

    public function getAnswerText(): ?string
    {
        return $this->answerText;
    }

    public function setAnswerText(?string $answerText): self
    {
        $this->answerText = $answerText;

        return $this;
    }

    public function getAnswerAuthor(): ?Doctor
    {
        return $this->answerAuthor;
    }

    public function setAnswerAuthor(?Doctor $answerAuthor): self
    {
        $this->answerAuthor = $answerAuthor;

        return $this;
    }

    public function __toString()
    {
        return '';
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @return Collection|Branch[]
     */
    public function getBranches(): Collection
    {
        return $this->branches;
    }

    public function addBranch(Branch $branch): self
    {
        if (!$this->branches->contains($branch)) {
            $this->branches[] = $branch;
        }

        return $this;
    }

    public function removeBranch(Branch $branch): self
    {
        $this->branches->removeElement($branch);

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getAuthorEmail(): ?string
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail(?string $authorEmail): self
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    public function getIsPublicationAllowed(): ?bool
    {
        return $this->isPublicationAllowed;
    }

    public function setIsPublicationAllowed(bool $isPublicationAllowed): self
    {
        $this->isPublicationAllowed = $isPublicationAllowed;

        return $this;
    }
}
