<?php

namespace App\Entity;

use App\Repository\ClinicRatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClinicRatingRepository::class)
 */
class ClinicRating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ReviewSource::class)
     */
    private $source;

    /**
     * @ORM\Column(type="float")
     */
    private $score;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getSource()->__toString();
    }
}
