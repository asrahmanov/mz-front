<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @UniqueEntity(fields={"slug"})
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $checkedAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class, inversedBy="articles")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $editor;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $expert;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $sources = [];

    /**
     * @ORM\ManyToMany(targetEntity=Article::class)
     */
    private $otherArticles;

    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=ArticleTag::class, inversedBy="articles")
     */
    private $tags;

    /**
     * @ORM\Column(type="json")
     */
    private $image = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $readingSeconds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewsNum;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPopular;

    /**
     * @ORM\OneToMany(targetEntity=ArticleComment::class, mappedBy="article")
     */
    private $comments;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $votesCount;

    public function __construct()
    {
        $this->otherArticles = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getCheckedAt(): ?\DateTimeInterface
    {
        return $this->checkedAt;
    }

    public function setCheckedAt(?\DateTimeInterface $checkedAt): self
    {
        $this->checkedAt = $checkedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuthor(): ?Doctor
    {
        return $this->author;
    }

    public function setAuthor(?Doctor $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getEditor(): ?Doctor
    {
        return $this->editor;
    }

    public function setEditor(?Doctor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getExpert(): ?Doctor
    {
        return $this->expert;
    }

    public function setExpert(?Doctor $expert): self
    {
        $this->expert = $expert;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSources(): ?array
    {
        return $this->sources;
    }

    public function setSources(?array $sources): self
    {
        $this->sources = $sources;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getOtherArticles(): Collection
    {
        return $this->otherArticles;
    }

    public function addOtherArticle(self $otherArticle): self
    {
        if (!$this->otherArticles->contains($otherArticle)) {
            $this->otherArticles[] = $otherArticle;
        }

        return $this;
    }

    public function removeOtherArticle(self $otherArticle): self
    {
        $this->otherArticles->removeElement($otherArticle);

        return $this;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection|ArticleTag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(ArticleTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(ArticleTag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getImage(): ?array
    {
        return $this->image;
    }

    public function setImage(array $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getReadingSeconds(): ?int
    {
        return $this->readingSeconds;
    }

    public function setReadingSeconds(?int $readingSeconds): self
    {
        $this->readingSeconds = $readingSeconds;

        return $this;
    }

    public function getViewsNum(): ?int
    {
        return $this->viewsNum;
    }

    public function setViewsNum(?int $viewsNum): self
    {
        $this->viewsNum = $viewsNum;

        return $this;
    }

    public function getIsPopular(): ?bool
    {
        return $this->isPopular;
    }

    public function setIsPopular(?bool $isPopular): self
    {
        $this->isPopular = $isPopular;

        return $this;
    }

    /**
     * @return Collection|ArticleComment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function getPublishedComments()
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('isPublished', true));
        return $this->comments->matching($criteria);
    }

    public function addComment(ArticleComment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(ArticleComment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getVotesCount(): ?int
    {
        return $this->votesCount;
    }

    public function setVotesCount(?int $votesCount): self
    {
        $this->votesCount = $votesCount;

        return $this;
    }
}
