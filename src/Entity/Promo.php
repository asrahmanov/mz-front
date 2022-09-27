<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @UniqueEntity(fields={"slug"})
 */
class Promo
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $activeUntil;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $image = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity=Clinic::class, inversedBy="promos")
     */
    private $clinics;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $promo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $specialPrice;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $new;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $onlineConsultation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class)
     */
    private $other;

    public function __construct()
    {
        $this->clinics = new ArrayCollection();
        $this->other = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getActiveUntil(): ?\DateTimeInterface
    {
        return $this->activeUntil;
    }

    public function setActiveUntil(?\DateTimeInterface $activeUntil): self
    {
        $this->activeUntil = $activeUntil;

        return $this;
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

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(?bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getSpecialPrice(): ?bool
    {
        return $this->specialPrice;
    }

    public function setSpecialPrice(bool $specialPrice): self
    {
        $this->specialPrice = $specialPrice;

        return $this;
    }

    public function getNew(): ?bool
    {
        return $this->new;
    }

    public function setNew(?bool $new): self
    {
        $this->new = $new;

        return $this;
    }

    public function getOnlineConsultation(): ?bool
    {
        return $this->onlineConsultation;
    }

    public function setOnlineConsultation(?bool $onlineConsultation): self
    {
        $this->onlineConsultation = $onlineConsultation;

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

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection|self[]
     */
    public function getOther(): Collection
    {
        return $this->other;
    }

    public function addOther(self $other): self
    {
        if (!$this->other->contains($other)) {
            $this->other[] = $other;
        }

        return $this;
    }

    public function removeOther(self $other): self
    {
        $this->other->removeElement($other);

        return $this;
    }
}
