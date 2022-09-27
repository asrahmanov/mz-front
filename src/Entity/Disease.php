<?php

namespace App\Entity;

use App\Repository\DiseaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DiseaseRepository::class)
 * @UniqueEntity(fields={"slug"})
 */
class Disease
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
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $author;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $expertComment;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $sources = [];

    /**
     * @ORM\OneToMany(targetEntity=DiseaseComment::class, mappedBy="disease")
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $readingSeconds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewsNum;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $editor;

    /**
     * @ORM\ManyToMany(targetEntity=Branch::class, mappedBy="diseases")
     */
    private $branches;

    /**
     * @ORM\ManyToMany(targetEntity=Treatment::class, inversedBy="diseases")
     */
    private $treatments;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $treatmentText;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class)
     */
    private $services;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textBeforeServices;

    /**
     * @ORM\ManyToMany(targetEntity=DiseaseCategory::class, inversedBy="diseases")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Symptom::class, inversedBy="diseases", cascade={"persist"}, orphanRemoval=true)
     */
    private $symptoms;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->branches = new ArrayCollection();
        $this->treatments = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->symptoms = new ArrayCollection();
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

    public function getExpertComment(): ?string
    {
        return $this->expertComment;
    }

    public function setExpertComment(?string $expertComment): self
    {
        $this->expertComment = $expertComment;

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
     * @return Collection|DiseaseComment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(DiseaseComment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setDisease($this);
        }

        return $this;
    }

    public function removeComment(DiseaseComment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getDisease() === $this) {
                $comment->setDisease(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getReadingSeconds(): ?int
    {
        return $this->readingSeconds;
    }

    public function setReadingSeconds($readingSeconds): self
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

    public function getEditor(): ?Doctor
    {
        return $this->editor;
    }

    public function setEditor(?Doctor $editor): self
    {
        $this->editor = $editor;

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
            $branch->addDisease($this);
        }

        return $this;
    }

    public function removeBranch(Branch $branch): self
    {
        if ($this->branches->removeElement($branch)) {
            $branch->removeDisease($this);
        }

        return $this;
    }

    /**
     * @return Collection|Treatment[]
     */
    public function getTreatments(): Collection
    {
        return $this->treatments;
    }

    public function addTreatment(Treatment $treatment): self
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments[] = $treatment;
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        $this->treatments->removeElement($treatment);

        return $this;
    }

    public function getTreatmentText(): ?string
    {
        return $this->treatmentText;
    }

    public function setTreatmentText(?string $treatmentText): self
    {
        $this->treatmentText = $treatmentText;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        $this->services->removeElement($service);

        return $this;
    }

    public function getTextBeforeServices(): ?string
    {
        return $this->textBeforeServices;
    }

    public function setTextBeforeServices(?string $textBeforeServices): self
    {
        $this->textBeforeServices = $textBeforeServices;

        return $this;
    }

    /**
     * @return Collection|DiseaseCategory[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(DiseaseCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(DiseaseCategory $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Symptom[]
     */
    public function getSymptoms(): Collection
    {
        return $this->symptoms;
    }

    public function addSymptom(Symptom $symptom): self
    {
        if (!$this->symptoms->contains($symptom)) {
            $this->symptoms[] = $symptom;
        }

        return $this;
    }

    public function removeSymptom(Symptom $symptom): self
    {
        $this->symptoms->removeElement($symptom);

        return $this;
    }
}
