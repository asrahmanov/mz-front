<?php

namespace App\Entity;

use App\Repository\PriceItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceItemRepository::class)
 */
class PriceItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=PriceCategory::class, inversedBy="priceItems")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Doctor::class, inversedBy="priceItems")
     */
    private $doctors;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $priceIsFrom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $value;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $promo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $new;

    /**
     * @ORM\ManyToMany(targetEntity=PriceTag::class, inversedBy="priceItems")
     */
    private $tags;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $oldValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $installment = false;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $additionalServices = [];

    public function __construct()
    {
        $this->doctors = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getCategory(): ?PriceCategory
    {
        return $this->category;
    }

    public function setCategory(?PriceCategory $category): self
    {
        $this->category = $category;

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

    public function getPriceIsFrom(): ?bool
    {
        return $this->priceIsFrom;
    }

    public function setPriceIsFrom(?bool $priceIsFrom): self
    {
        $this->priceIsFrom = $priceIsFrom;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(bool $promo): self
    {
        $this->promo = $promo;

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

    /**
     * @return Collection|PriceTag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(PriceTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(PriceTag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getOldValue(): ?int
    {
        return $this->oldValue;
    }

    public function setOldValue(?int $oldValue): self
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    public function getFullName()
    {
        $category = $this->getCategory();
        $result = $category->__toString() . ' > ' . $this->__toString();
        if ($parentCategory = $category->getParrentCategory()) {
            $result = $parentCategory->__toString() . ' > ' . $result;
        }
        return $result;
    }

    public function getInstallment(): ?bool
    {
        return $this->installment;
    }

    public function setInstallment(bool $installment): self
    {
        $this->installment = $installment;

        return $this;
    }

    public function getAdditionalServices(): ?array
    {
        return $this->additionalServices;
    }

    public function setAdditionalServices(?array $additionalServices): self
    {
        $this->additionalServices = $additionalServices;

        return $this;
    }

}
