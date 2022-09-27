<?php

namespace App\Entity;

use App\Repository\TreatmentQARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TreatmentQARepository::class)
 */
class TreatmentQA
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
     * @ORM\ManyToMany(targetEntity=Treatment::class, mappedBy="qAs")
     */
    private $treatments;

    public function __construct()
    {
        $this->treatments = new ArrayCollection();
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
            $treatment->addQA($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->removeElement($treatment)) {
            $treatment->removeQA($this);
        }

        return $this;
    }

    public function getTreatmentsList() : string
    {
        $treatmentsArr = $this->getTreatments()->toArray();

        $result =  array_map(function($el) {
            return $el->getName();
        }, $treatmentsArr);

        return implode(', ', $result);

    }

    public function __toString(): string
    {
        return $this->getQuestionText();
    }
}
