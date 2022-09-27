<?php

namespace App\Entity;

use App\Repository\DoctorRatingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DoctorRatingRepository::class)
 */
class DoctorRating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Range(min = 1, max = 5)
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=ReviewSource::class)
     */
    private $source;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getSource(): ?ReviewSource
    {
        return $this->source;
    }

    public function setSource(?ReviewSource $source): self
    {
        $this->source = $source;

        return $this;
    }
}
