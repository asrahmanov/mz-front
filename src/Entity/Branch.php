<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BranchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BranchRepository::class)
 * @UniqueEntity(fields={"slug"})
 * @ApiResource(normalizationContext={
 *     "groups"={"branch:read"},
 * })
 */
class Branch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"branch:read"});
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"branch:read"});
     */
    private $name;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $image1 = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $image2 = [];

    /**
     * @ORM\ManyToMany(targetEntity=Clinic::class, inversedBy="branches")
     */
    private $clinics;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity=Doctor::class, inversedBy="branches")
     */
    private $doctors;

    /**
     * @ORM\ManyToMany(targetEntity=Symptom::class, inversedBy="branches", cascade={"persist"}, orphanRemoval=true)
     */
    private $symptoms;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Disease::class, inversedBy="branches")
     */
    private $diseases;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, inversedBy="branches")
     */
    private $services;

    /**
     * @ORM\ManyToMany(targetEntity=Hardware::class, inversedBy="branches")
     */
    private $hardware;

    /**
     * @ORM\ManyToMany(targetEntity=Treatment::class, inversedBy="branches")
     */
    private $treatments;

    /**
     * @ORM\ManyToMany(targetEntity=QA::class, mappedBy="branches")
     */
    private $qAs;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showInMainPage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $treatmentsText;

    /**
     * @ORM\ManyToMany(targetEntity=PriceItem::class)
     */
    private $priceItems;

    /**
     * @ORM\ManyToMany(targetEntity=Review::class)
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class)
     */
    private $articles;

    public function __construct()
    {
        $this->clinics = new ArrayCollection();
        $this->doctors = new ArrayCollection();
        $this->symptoms = new ArrayCollection();
        $this->diseases = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->hardware = new ArrayCollection();
        $this->treatments = new ArrayCollection();
        $this->qAs = new ArrayCollection();
        $this->showInMainPage = false;
        $this->priceItems = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->articles = new ArrayCollection();
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

    public function getImage1(): ?array
    {
        return $this->image1;
    }

    public function setImage1(?array $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    public function getImage2(): ?array
    {
        return $this->image2;
    }

    public function setImage2(?array $image2): self
    {
        $this->image2 = $image2;

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

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

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
        }

        return $this;
    }

    public function removeDisease(Disease $disease): self
    {
        $this->diseases->removeElement($disease);

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

    /**
     * @return Collection|Hardware[]
     */
    public function getHardware(): Collection
    {
        return $this->hardware;
    }

    public function addHardware(Hardware $hardware): self
    {
        if (!$this->hardware->contains($hardware)) {
            $this->hardware[] = $hardware;
        }

        return $this;
    }

    public function removeHardware(Hardware $hardware): self
    {
        $this->hardware->removeElement($hardware);

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

    /**
     * @return Collection|QA[]
     */
    public function getQAs(): Collection
    {
        return $this->qAs;
    }

    public function addQA(QA $qA): self
    {
        if (!$this->qAs->contains($qA)) {
            $this->qAs[] = $qA;
            $qA->addBranch($this);
        }

        return $this;
    }

    public function removeQA(QA $qA): self
    {
        if ($this->qAs->removeElement($qA)) {
            $qA->removeBranch($this);
        }

        return $this;
    }

    public function getShowInMainPage(): ?bool
    {
        return $this->showInMainPage;
    }

    public function setShowInMainPage(bool $showInMainPage): self
    {
        $this->showInMainPage = $showInMainPage;

        return $this;
    }

    public function getTreatmentsText(): ?string
    {
        return $this->treatmentsText;
    }

    public function setTreatmentsText(?string $treatmentsText): self
    {
        $this->treatmentsText = $treatmentsText;

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
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->articles->removeElement($article);

        return $this;
    }
}
