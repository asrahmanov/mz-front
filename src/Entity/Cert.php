<?php

namespace App\Entity;

use App\Repository\CertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CertRepository::class)
 */
class Cert
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
    private $image = [];

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class, inversedBy="certs")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $doctor;

    /**
     * @ORM\ManyToMany(targetEntity=Clinic::class, cascade={"persist", "remove", "detach"}, mappedBy="certs")
     */
    private $clinics;

    public function __construct()
    {
        $this->clinics = new ArrayCollection();
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

    public function getImage(): ?array
    {
        return $this->image;
    }

    public function setImage(?array $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * @return Collection|Clinic[]
     */
    public function getCerts(): Collection
    {
        return $this->clinics;
    }

    public function addCert(Cert $cert): self
    {
        if (!$this->clinics->contains($cert)) {
            $this->clinics[] = $cert;
        }

        return $this;
    }

    public function removeCert(Cert $cert): self
    {
        $this->clinics->removeElement($cert);

        return $this;
    }
}
