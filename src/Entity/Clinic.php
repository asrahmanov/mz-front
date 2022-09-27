<?php

namespace App\Entity;

use App\Repository\ClinicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClinicRepository::class)
 * @UniqueEntity("isMain", repositoryMethod="validateThatMainIsUnique", ignoreNull=true)
 * @UniqueEntity("slug")
 */
class Clinic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("doctor_appointment:read")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=DoctorSchedule::class, mappedBy="clinic")
     */
    private $doctorSchedules;

    /**
     * @ORM\ManyToMany(targetEntity=Branch::class, mappedBy="clinics")
     */
    private $branches;

    /**
     * @ORM\ManyToMany(targetEntity=Doctor::class, mappedBy="clinics")
     */
    private $doctors;

    /**
     * @ORM\ManyToMany(targetEntity=Treatment::class, mappedBy="clinics")
     */
    private $treatments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $distance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, mappedBy="clinics")
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="clinic")
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="clinics")
     */
    private $promos;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $photo = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $gallery = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tour3d;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMain;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="json", nullable=true)
     */
    private $coords = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $parkingCoords = [];

    /**
     * @ORM\ManyToMany(targetEntity=Cert::class, cascade={"persist", "remove", "detach"}, inversedBy="clinics")
     */
    private $certs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $legalName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contactInfo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $socVk;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $socFb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $socYoutube;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $socInsta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $socTelegram;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $legalInfo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $parkingInfo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel;

    public function __construct()
    {
        $this->doctorSchedules = new ArrayCollection();
        $this->branches = new ArrayCollection();
        $this->doctors = new ArrayCollection();
        $this->treatments = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->promos = new ArrayCollection();
        $this->certs = new ArrayCollection();
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

    /**
     * @return Collection|DoctorSchedule[]
     */
    public function getDoctorSchedules(): Collection
    {
        return $this->doctorSchedules;
    }

    public function addSchedule(DoctorSchedule $schedule): self
    {
        if (!$this->doctorSchedules->contains($schedule)) {
            $this->doctorSchedules[] = $schedule;
            $schedule->setClinic($this);
        }

        return $this;
    }

    public function removeSchedule(DoctorSchedule $schedule): self
    {
        if ($this->doctorSchedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getClinic() === $this) {
                $schedule->setClinic(null);
            }
        }

        return $this;
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
            $branch->addClinic($this);
        }

        return $this;
    }

    public function removeBranch(Branch $branch): self
    {
        if ($this->branches->removeElement($branch)) {
            $branch->removeClinic($this);
        }

        return $this;
    }

    /**
     * @return Collection|Doctor[]
     */
    public function getDoctors(): Collection
    {
        return $this->doctors;
    }

    public function addDoctor(Doctor $doctor): self
    {
        if (!$this->doctors->contains($doctor)) {
            $this->doctors[] = $doctor;
            $doctor->addClinic($this);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        if ($this->doctors->removeElement($doctor)) {
            $doctor->removeClinic($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
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
            $treatment->addClinic($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->removeElement($treatment)) {
            $treatment->removeClinic($this);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

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
            $service->addClinic($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            $service->removeClinic($this);
        }

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setClinic($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getClinic() === $this) {
                $review->setClinic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addClinic($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeClinic($this);
        }

        return $this;
    }

    public function getPhoto(): ?array
    {
        return $this->photo;
    }

    public function setPhoto(array $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getGallery(): ?array
    {
        return $this->gallery;
    }

    public function setGallery(?array $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getTour3d(): ?string
    {
        return $this->tour3d;
    }

    public function setTour3d(?string $tour3d): self
    {
        $this->tour3d = $tour3d;

        return $this;
    }

    public function getIsMain(): ?bool
    {
        return $this->isMain;
    }

    public function setIsMain(?bool $isMain): self
    {
        $this->isMain = $isMain;

        return $this;
    }

    public function getCoords(): ?array
    {
        return $this->coords;
    }

    public function setCoords(?array $coords): self
    {
        $this->coords = $coords;

        return $this;
    }

    public function getParkingCoords(): ?array
    {
        return $this->parkingCoords;
    }

    public function setParkingCoords(?array $parkingCoords): self
    {
        $this->parkingCoords = $parkingCoords;

        return $this;
    }

    /**
     * @return Collection|Cert[]
     */
    public function getCerts(): Collection
    {
        return $this->certs;
    }

    public function addCert(Cert $cert): self
    {
        if (!$this->certs->contains($cert)) {
            $this->certs[] = $cert;
        }

        return $this;
    }

    public function removeCert(Cert $cert): self
    {
        $this->certs->removeElement($cert);

        return $this;
    }

    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    public function setLegalName(?string $legalName): self
    {
        $this->legalName = $legalName;

        return $this;
    }

    public function getContactInfo(): ?string
    {
        return $this->contactInfo;
    }

    public function setContactInfo(?string $contactInfo): self
    {
        $this->contactInfo = $contactInfo;

        return $this;
    }

    public function getSocVk(): ?string
    {
        return $this->socVk;
    }

    public function setSocVk(?string $socVk): self
    {
        $this->socVk = $socVk;

        return $this;
    }

    public function getSocFb(): ?string
    {
        return $this->socFb;
    }

    public function setSocFb(?string $socFb): self
    {
        $this->socFb = $socFb;

        return $this;
    }

    public function getSocYoutube(): ?string
    {
        return $this->socYoutube;
    }

    public function setSocYoutube(?string $socYoutube): self
    {
        $this->socYoutube = $socYoutube;

        return $this;
    }

    public function getSocInsta(): ?string
    {
        return $this->socInsta;
    }

    public function setSocInsta(?string $socInsta): self
    {
        $this->socInsta = $socInsta;

        return $this;
    }

    public function getSocTelegram(): ?string
    {
        return $this->socTelegram;
    }

    public function setSocTelegram(?string $socTelegram): self
    {
        $this->socTelegram = $socTelegram;

        return $this;
    }

    public function getLegalInfo(): ?string
    {
        return $this->legalInfo;
    }

    public function setLegalInfo(?string $legalInfo): self
    {
        $this->legalInfo = $legalInfo;

        return $this;
    }

    public function getParkingInfo(): ?string
    {
        return $this->parkingInfo;
    }

    public function setParkingInfo(?string $parkingInfo): self
    {
        $this->parkingInfo = $parkingInfo;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }
}
