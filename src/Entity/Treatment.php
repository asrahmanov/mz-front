<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TreatmentRepository::class)
 * @UniqueEntity(fields={"slug"})
 */
class Treatment
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\ManyToMany(targetEntity=Clinic::class, inversedBy="treatments")
     */
    private $clinics;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $proceduresCount;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $indications;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contraindications;

    /**
     * @ORM\ManyToMany(targetEntity=Treatment::class)
     */
    private $relatedTreatments;

    /**
     * @ORM\ManyToMany(targetEntity=Doctor::class, inversedBy="treatments")
     */
    private $doctors;

    /**
     * @ORM\ManyToMany(targetEntity=TreatmentQA::class, inversedBy="treatments")
     */
    private $qAs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $image = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $courseCost;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $relatedTreatmentsText;

    /**
     * @ORM\ManyToMany(targetEntity=Branch::class, mappedBy="treatments")
     */
    private $branches;

    /**
     * @ORM\ManyToMany(targetEntity=Disease::class, mappedBy="treatments")
     */
    private $diseases;

    /**
     * @ORM\ManyToMany(targetEntity=Review::class)
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=PriceItem::class)
     */
    private $priceItems;

    public function __construct()
    {
        $this->clinics = new ArrayCollection();
        $this->relatedTreatments = new ArrayCollection();
        $this->doctors = new ArrayCollection();
        $this->qAs = new ArrayCollection();
        $this->branches = new ArrayCollection();
        $this->diseases = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->priceItems = new ArrayCollection();
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

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return Collection|Clinic[]
     */
    public function getClinics(): Collection
    {
        return $this->clinics;
    }

    public function addClinic(Clinic $clinic): self
    {
        if (!$this->clinics->contains($clinic)) {
            $this->clinics[] = $clinic;
        }

        return $this;
    }

    public function removeClinic(Clinic $clinic): self
    {
        $this->clinics->removeElement($clinic);

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getProceduresCount(): ?string
    {
        return $this->proceduresCount;
    }

    public function setProceduresCount(?string $proceduresCount): self
    {
        $this->proceduresCount = $proceduresCount;

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

    public function getIndications(): ?string
    {
        return $this->indications;
    }

    public function setIndications(?string $indications): self
    {
        $this->indications = $indications;

        return $this;
    }

    public function getContraindications(): ?string
    {
        return $this->contraindications;
    }

    public function setContraindications(?string $contraindications): self
    {
        $this->contraindications = $contraindications;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRelatedTreatments(): Collection
    {
        return $this->relatedTreatments;
    }

    public function addRelatedTreatment(self $relatedTreatment): self
    {
        if (!$this->relatedTreatments->contains($relatedTreatment)) {
            $this->relatedTreatments[] = $relatedTreatment;
        }

        return $this;
    }

    public function removeRelatedTreatment(self $relatedTreatment): self
    {
        $this->relatedTreatments->removeElement($relatedTreatment);

        return $this;
    }

    /**
     * @return Collection|Doctor[]
     */
    public function getDoctors(): Collection
    {
        return $this->doctors;
    }

    public function addDoctor(Doctor $doctor): self
    {
        if (!$this->doctors->contains($doctor)) {
            $this->doctors[] = $doctor;
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        $this->doctors->removeElement($doctor);

        return $this;
    }

    /**
     * @return Collection|TreatmentQA[]
     */
    public function getQAs(): Collection
    {
        return $this->qAs;
    }

    public function addQA(TreatmentQA $qA): self
    {
        if (!$this->qAs->contains($qA)) {
            $this->qAs[] = $qA;
        }

        return $this;
    }

    public function removeQA(TreatmentQA $qA): self
    {
        $this->qAs->removeElement($qA);

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

    public function getImage(): ?array
    {
        return $this->image;
    }

    public function setImage(?array $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(?string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCourseCost(): ?string
    {
        return $this->courseCost;
    }

    public function setCourseCost(?string $courseCost): self
    {
        $this->courseCost = $courseCost;

        return $this;
    }

    public function getRelatedTreatmentsText(): ?string
    {
        return $this->relatedTreatmentsText;
    }

    public function setRelatedTreatmentsText(?string $relatedTreatmentsText): self
    {
        $this->relatedTreatmentsText = $relatedTreatmentsText;

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
            $branch->addTreatment($this);
        }

        return $this;
    }

    public function removeBranch(Branch $branch): self
    {
        if ($this->branches->removeElement($branch)) {
            $branch->removeTreatment($this);
        }

        return $this;
    }

    /**
     * @return Collection|Disease[]
     */
    public function getDiseases(): Collection
    {
        return $this->diseases;
    }

    public function addDisease(Disease $disease): self
    {
        if (!$this->diseases->contains($disease)) {
            $this->diseases[] = $disease;
            $disease->addTreatment($this);
        }

        return $this;
    }

    public function removeDisease(Disease $disease): self
    {
        if ($this->diseases->removeElement($disease)) {
            $disease->removeTreatment($this);
        }

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        $this->reviews->removeElement($review);

        return $this;
    }

    /**
     * @return Collection|PriceItem[]
     */
    public function getPriceItems(): Collection
    {
        return $this->priceItems;
    }

    public function addPriceItem(PriceItem $priceItem): self
    {
        if (!$this->priceItems->contains($priceItem)) {
            $this->priceItems[] = $priceItem;
        }

        return $this;
    }

    public function removePriceItem(PriceItem $priceItem): self
    {
        $this->priceItems->removeElement($priceItem);

        return $this;
    }
}
