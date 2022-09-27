<?php

namespace App\Entity;

use App\Repository\DoctorScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DoctorScheduleRepository::class)
 */
class DoctorSchedule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class, inversedBy="schedules")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $doctor;

    /**
     * @ORM\ManyToOne(targetEntity=Clinic::class, inversedBy="doctorSchedules")
     */
    private $clinic;

    /**
     * @ORM\ManyToMany(targetEntity=DoctorScheduleDate::class, inversedBy="doctorSchedules", cascade={"persist", "remove", "detach"}, orphanRemoval=true)
     */
    private $dates;

    public function __construct()
    {
        $this->dates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClinic(): ?Clinic
    {
        return $this->clinic;
    }

    public function setClinic(?Clinic $clinic): self
    {
        $this->clinic = $clinic;

        return $this;
    }

    /**
     * @return Collection|DoctorScheduleDate[]
     */
    public function getDates(): Collection
    {
        return $this->dates;
    }

    public function addDate(DoctorScheduleDate $date): self
    {
        if (!$this->dates->contains($date)) {
            $this->dates[] = $date;
        }

        return $this;
    }

    public function removeDate(DoctorScheduleDate $date): self
    {
        $this->dates->removeElement($date);

        return $this;
    }

    public function __toString()
    {
        return $this->getDoctor() . ' - ' . $this->getClinic();
    }
}
