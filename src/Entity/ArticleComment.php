<?php

namespace App\Entity;

use App\Repository\ArticleCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\UnicodeString;

/**
 * @ORM\Entity(repositoryClass=ArticleCommentRepository::class)
 */
class ArticleComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authorName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $authorTel;

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
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments")
     */
    private $article;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->isPublished = false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function __toString(): string
    {
        return (new UnicodeString($this->getText()))->truncate('120', '...');
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
}
