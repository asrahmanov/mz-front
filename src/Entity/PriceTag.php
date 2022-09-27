<?php

namespace App\Entity;

use App\Repository\PriceTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceTagRepository::class)
 */
class PriceTag
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
     * @ORM\ManyToMany(targetEntity=PriceItem::class, mappedBy="tags")
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
            $priceItem->addTag($this);
        }

        return $this;
    }

    public function removePriceItem(PriceItem $priceItem): self
    {
        if ($this->priceItems->removeElement($priceItem)) {
            $priceItem->removeTag($this);
        }

        return $this;
    }
}
