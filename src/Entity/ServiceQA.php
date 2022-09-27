<?php

namespace App\Entity;

use App\Repository\ServiceQARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceQARepository::class)
 */
class ServiceQA
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $questionText;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $answerAuthor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $answerText;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, mappedBy="qAs")
     */
    private $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    public function setQuestionText(?string $questionText): self
    {
        $this->questionText = $questionText;

        return $this;
    }

    public function getAnswerAuthor(): ?Doctor
    {
        return $this->answerAuthor;
    }

    public function setAnswerAuthor(?Doctor $answerAuthor): self
    {
        $this->answerAuthor = $answerAuthor;

        return $this;
    }

    public function getAnswerText(): ?string
    {
        return $this->answerText;
    }

    public function setAnswerText(?string $answerText): self
    {
        $this->answerText = $answerText;

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
            $service->addQA($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            $service->removeQA($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getQuestionText();
    }
}
