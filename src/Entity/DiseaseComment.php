<?php

namespace App\Entity;

use App\Repository\DiseaseCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiseaseCommentRepository::class)
 */
class DiseaseComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $authorName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $authorTel;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $answerAuthor;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $answerDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $answerText;

    /**
     * @ORM\ManyToOne(targetEntity=Disease::class, inversedBy="comments")
     */
    private $disease;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(?string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getAuthorTel(): ?string
    {
        return $this->authorTel;
    }

    public function setAuthorTel(?string $authorTel): self
    {
        $this->authorTel = $authorTel;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

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

    public function getAnswerDate(): ?\DateTimeInterface
    {
        return $this->answerDate;
    }

    public function setAnswerDate(?\DateTimeInterface $answerDate): self
    {
        $this->answerDate = $answerDate;

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

    public function getDisease(): ?Disease
    {
        return $this->disease;
    }

    public function setDisease(?Disease $disease): self
    {
        $this->disease = $disease;

        return $this;
    }

    public function __toString(): string
    {
        return '';
    }
}
