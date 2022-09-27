<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DoctorAppointmentRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(normalizationContext={
 *     "groups"={"doctor_appointment:read"},
 *     "datetime_format"="d.m.Y H:i:s"
 * })
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(SearchFilter::class, properties={
 *     "doctor": "exact",
 *     "doctor.lastname": "partial"
 * })
 * @ORM\Entity(repositoryClass=DoctorAppointmentRepository::class)
 */
class DoctorAppointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("doctor_appointment:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class, inversedBy="doctorAppointments")
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Groups("doctor_appointment:read")
     */
    private $doctor;

    /**
     * @ORM\ManyToOne(targetEntity=Clinic::class)
     * @Groups("doctor_appointment:read")
     */
    private $clinic;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups("doctor_appointment:read")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $patientName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $patientTel;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPatientName(): ?string
    {
        return $this->patientName;
    }

    public function setPatientName(string $patientName): self
    {
        $this->patientName = $patientName;

        return $this;
    }

    public function getPatientTel(): ?string
    {
        return $this->patientTel;
    }

    public function setPatientTel(string $patientTel): self
    {
        $this->patientTel = $patientTel;

        return $this;
    }
}
