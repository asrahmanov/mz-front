<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 * @UniqueEntity(fields={"slug"})
 */
class Service
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
     * @ORM\Column(type="json", nullable=true)
     */
    private $image1;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $image2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $priceFrom;

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
     * @ORM\Column(type="json", nullable=true)
     */
    private $advantages = [];

    /**
     * @ORM\ManyToMany(targetEntity=Doctor::class, inversedBy="services")
     */
    private $doctors;

    /**
     * @ORM\ManyToMany(targetEntity=ServiceQA::class, inversedBy="services")
     */
    private $qAs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="children")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\ManyToMany(targetEntity=Clinic::class, inversedBy="services")
     */
    private $clinics;

    /**
     * @ORM\ManyToMany(targetEntity=PriceItem::class)
     */
    private $priceItems;

    /**
     * @ORM\ManyToMany(targetEntity=Review::class)
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=Hardware::class)
     */
    private $hardwares;

    /**
     * @ORM\ManyToMany(targetEntity=Branch::class, mappedBy="services")
     */
    private $branches;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class)
     */
    private $articles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showInMainPage;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class)
     */
    private $promos;

    public function __construct()
    {
        $this->doctors = new ArrayCollection();
        $this->qAs = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->clinics = new ArrayCollection();
        $this->priceItems = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->hardwares = new ArrayCollection();
        $this->branches = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->showInMainPage = false;
        $this->promos = new ArrayCollection();
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

    public function getPriceFrom(): ?string
    {
        return $this->priceFrom;
    }

    public function setPriceFrom(?string $priceFrom): self
    {
        $this->priceFrom = $priceFrom;

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

    public function getAdvantages(): ?array
    {
        return $this->advantages;
    }

    public function setAdvantages(?array $advantages): self
    {
        $this->advantages = $advantages;

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
     * @return Collection|ServiceQA[]
     */
    public function getQAs(): Collection
    {
        return $this->qAs;
    }

    public function addQA(ServiceQA $qA): self
    {
        if (!$this->qAs->contains($qA)) {
            $this->qAs[] = $qA;
        }

        return $this;
    }

    public function removeQA(ServiceQA $qA): self
    {
        $this->qAs->removeElement($qA);

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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getPath()
    {
        $result = $this->getSlug();
        $service = $this;

        while($service->getParent()){
            $service = $service->getParent();
            $result = $service->getSlug() . '/' . $result;
        }

        return $result;
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
        $criteria = Criteria::create()->orderBy(['video' => Criteria::DESC]);
        return $this->reviews->matching($criteria);
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
     * @return Collection|Hardware[]
     */
    public function getHardwares(): Collection
    {
        return $this->hardwares;
    }

    public function addHardware(Hardware $hardware): self
    {
        if (!$this->hardwares->contains($hardware)) {
            $this->hardwares[] = $hardware;
        }

        return $this;
    }

    public function removeHardware(Hardware $hardware): self
    {
        $this->hardwares->removeElement($hardware);

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
            $branch->addService($this);
        }

        return $this;
    }

    public function removeBranch(Branch $branch): self
    {
        if ($this->branches->removeElement($branch)) {
            $branch->removeService($this);
        }

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

    public function getShowInMainPage(): ?bool
    {
        return $this->showInMainPage;
    }

    public function setShowInMainPage(bool $showInMainPage): self
    {
        $this->showInMainPage = $showInMainPage;

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        $this->promos->removeElement($promo);

        return $this;
    }
}
