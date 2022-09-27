<?php

namespace App\Entity;

use App\Repository\SymptomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SymptomRepository::class)
 */
class Symptom
{
    const COLORS = [
        0 => 'green',
        1 => 'yellow',
        2 => 'red'
    ];
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
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hazard;

    /**
     * @ORM\ManyToMany(targetEntity=Branch::class, mappedBy="symptoms")
     */
    private $branches;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity=Disease::class, mappedBy="symptoms")
     */
    private $diseases;

    public function __construct()
    {
        $this->branches = new ArrayCollection();
        $this->diseases = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHazard(): ?int
    {
        return $this->hazard;
    }

    public function setHazard(?int $hazard): self
    {
        $this->hazard = $hazard;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
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
            $branch->addSymptom($this);
        }

        return $this;
    }

    public function removeBranch(Branch $branch): self
    {
        if ($this->branches->removeElement($branch)) {
            $branch->removeSymptom($this);
        }

        return $this;
    }

    public function getColor()
    {
        return self::COLORS[$this->getHazard()];
    }

    public function getLocation(): ?int
    {
        return $this->location;
    }

    public function setLocation(?int $location): self
    {
        $this->location = $location;

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
            $disease->addSymptom($this);
        }

        return $this;
    }

    public function removeDisease(Disease $disease): self
    {
        if ($this->diseases->removeElement($disease)) {
            $disease->removeSymptom($this);
        }

        return $this;
    }
}
