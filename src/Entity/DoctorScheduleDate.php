<?php

namespace App\Entity;

use App\Repository\DoctorScheduleDateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DoctorScheduleDateRepository::class)
 */
class DoctorScheduleDate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=DoctorSchedule::class, mappedBy="dates")
     */
    private $doctorSchedules;

    public function __construct()
    {
        $this->doctorSchedules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|DoctorSchedule[]
     */
    public function getSchedules(): Collection
    {
        return $this->doctorSchedules;
    }

    public function addSchedule(DoctorSchedule $schedule): self
    {
        if (!$this->doctorSchedules->contains($schedule)) {
            $this->doctorSchedules[] = $schedule;
            $schedule->addDate($this);
        }

        return $this;
    }

    public function removeSchedule(DoctorSchedule $schedule): self
    {
        if ($this->doctorSchedules->removeElement($schedule)) {
            $schedule->removeDate($this);
        }

        return $this;
    }
}
