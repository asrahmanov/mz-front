<?php

namespace App\Entity;

use App\Repository\PriceCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceCategoryRepository::class)
 */
class PriceCategory
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
     * @ORM\ManyToOne(targetEntity=PriceCategory::class, inversedBy="categories")
     */
    private $parrentCategory;

    /**
     * @ORM\OneToMany(targetEntity=PriceCategory::class, mappedBy="parrentCategory")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=PriceItem::class, mappedBy="category")
     */
    private $priceItems;

    public function __construct()
    {
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

    public function getParrentCategory(): ?self
    {
        return $this->parrentCategory;
    }

    public function setParrentCategory(?self $parrentCategory): self
    {
        $this->parrentCategory = $parrentCategory;

        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function __toString(): string
    {
        return $this->getName();
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
            $priceItem->setCategory($this);
        }

        return $this;
    }

    public function removePriceItem(PriceItem $priceItem): self
    {
        if ($this->priceItems->removeElement($priceItem)) {
            // set the owning side to null (unless already changed)
            if ($priceItem->getCategory() === $this) {
                $priceItem->setCategory(null);
            }
        }

        return $this;
    }

    public function hasPromo()
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('promo', true));

        $result = $this->priceItems->matching($criteria)->count();

        if (!$result) {
            foreach ($this->categories as $category) {
                $result = $category->priceItems->matching($criteria)->count();
                if ($result) {
                    return $result;
                }
            }
        }

        return (boolean)$result;
    }

    public function hasNew()
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('new', true));
        $result = $this->priceItems->matching($criteria)->count();

        if (!$result) {
            foreach ($this->categories as $category) {
                $result = $category->priceItems->matching($criteria)->count();
                if ($result) {
                    return $result;
                }
            }
        }

        return (boolean)$result;
    }

    public function getDoctors(): ?ArrayCollection
    {
        $doctors = new ArrayCollection();
        foreach ($this->priceItems as $priceItem) {
            foreach ($priceItem->getDoctors() as $doctor) {
                if (!$doctors->contains($doctor)) {
                    $doctors->add($doctor);
                }
            }
        }

        foreach ($this->categories as $category) {
            $tmpDoctors = $category->getDoctors();
            foreach ($tmpDoctors as $doctor) {
                if (! $doctors->contains($doctor)) {
                    $doctors->add($doctor);
                }
            }
        }

        return $doctors;
    }
}
