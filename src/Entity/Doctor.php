<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DoctorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(normalizationContext={
 *     "groups"={"doctor:read"},
 *     "datetime_format"="d.m.Y H:i:s"
 * })
 * @ORM\Entity(repositoryClass=DoctorRepository::class)
 * @UniqueEntity(fields={"slug"})
 */
class Doctor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("doctor:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"doctor_appointment:read", "doctor:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middlename;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $post;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $experience;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     * @Assert\Regex(pattern="/^[a-zA-Z\-_\d]+$/", message="Требуется указать код видео. Например: PH6JUtCaykQ.")
     */
    private $video;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $promo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $onlineConsultation;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $education = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $additionalEducation = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $achievements = [];

    /**
     * @ORM\OneToMany(targetEntity=DoctorSchedule::class, mappedBy="doctor")
     */
    private $schedules;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $gallery;

    /**
     * @ORM\OneToMany(targetEntity=QA::class, mappedBy="answerAuthor")
     */
    private $qAs;

    /**
     * @ORM\ManyToMany(targetEntity=Branch::class, mappedBy="doctors")
     */
    private $branches;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $leadingSpecialist;

    /**
     * @ORM\ManyToMany(targetEntity=Clinic::class, inversedBy="doctors")
     */
    private $clinics;

    /**
     * @ORM\ManyToMany(targetEntity=Treatment::class, mappedBy="doctors")
     */
    private $treatments;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, mappedBy="doctors")
     */
    private $services;

    /**
     * @ORM\ManyToMany(targetEntity=Specialty::class, inversedBy="doctors")
     */
    private $specialties;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=PriceItem::class, mappedBy="doctors")
     */
    private $priceItems;

    /**
     * @ORM\ManyToMany(targetEntity=Review::class, mappedBy="doctors")
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity=Cert::class, mappedBy="doctor", cascade={"persist", "remove", "detach"})
     */
    private $certs;

    /**
     * @ORM\ManyToOne(targetEntity=DoctorRating::class, cascade={"persist"})
     */
    private $rating1;

    /**
     * @ORM\ManyToOne(targetEntity=DoctorRating::class, cascade={"persist"})
     */
    private $rating2;

    /**
     * @ORM\ManyToOne(targetEntity=PriceItem::class)
     */
    private $appointment;

    /**
     * @ORM\OneToMany(targetEntity=DoctorAppointment::class, mappedBy="doctor")
     */
    private $doctorAppointments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnabled = true;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
        $this->qAs = new ArrayCollection();
        $this->branches = new ArrayCollection();
        $this->clinics = new ArrayCollection();
        $this->treatments = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->specialties = new ArrayCollection();
        $this->priceItems = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->certs = new ArrayCollection();
        $this->doctorAppointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getMiddlename(): ?string
    {
        return $this->middlename;
    }

    public function setMiddlename(?string $middlename): self
    {
        $this->middlename = $middlename;

        return $this;
    }

    public function getPhoto(): ?array
    {
        return $this->photo;
    }

    public function setPhoto(?array $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(?string $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(?bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getOnlineConsultation(): ?bool
    {
        return $this->onlineConsultation;
    }

    public function setOnlineConsultation(bool $onlineConsultation): self
    {
        $this->onlineConsultation = $onlineConsultation;

        return $this;
    }

    public function getEducation(): ?array
    {
        return $this->education;
    }

    public function setEducation(?array $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getAdditionalEducation(): ?array
    {
        return $this->additionalEducation;
    }

    public function setAdditionalEducation(?array $additionalEducation): self
    {
        $this->additionalEducation = $additionalEducation;

        return $this;
    }

    /**
     * @Groups("doctor_appointment:read")
     */
    public function getFullName()
    {
        return join(' ', [$this->firstname, $this->middlename, $this->lastname]);
    }


    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function getAchievements(): ?array
    {
        return $this->achievements;
    }

    public function setAchievements(?array $achievements): self
    {
        $this->achievements = $achievements;

        return $this;
    }

    /**
     * @return Collection|DoctorSchedule[]
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(DoctorSchedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setDoctor($this);
        }

        return $this;
    }

    public function removeSchedule(DoctorSchedule $schedule): self
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getDoctor() === $this) {
                $schedule->setDoctor(null);
            }
        }

        return $this;
    }

    public function getGallery()
    {
        return $this->gallery;
    }

    public function setGallery($gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return Collection|QA[]
     */
    public function getQAs(): Collection
    {
        return $this->qAs;
    }

    /**
     * @return Collection|QA[]
     */
    public function getPublishedQAs(): Collection
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('isPublished', true));
        return $this->qAs->matching($criteria);
    }

    public function addQA(QA $qA): self
    {
        if (!$this->qAs->contains($qA)) {
            $this->qAs[] = $qA;
            $qA->setAnswerAuthor($this);
        }

        return $this;
    }

    public function removeQA(QA $qA): self
    {
        if ($this->qAs->removeElement($qA)) {
            // set the owning side to null (unless already changed)
            if ($qA->getAnswerAuthor() === $this) {
                $qA->setAnswerAuthor(null);
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
            $branch->addDoctor($this);
        }

        return $this;
    }

    public function removeBranch(Branch $branch): self
    {
        if ($this->branches->removeElement($branch)) {
            $branch->removeDoctor($this);
        }

        return $this;
    }

    public function getLeadingSpecialist(): ?bool
    {
        return $this->leadingSpecialist;
    }

    public function setLeadingSpecialist(?bool $leadingSpecialist): self
    {
        $this->leadingSpecialist = $leadingSpecialist;

        return $this;
    }

    /**
     * @return Collection|Clinic[]
     */
    public function getClinics(): Collection
    {
        return $this->clinics;
    }

    public function addClinic(Clinic $clinic): self
    {
        if (!$this->clinics->contains($clinic)) {
            $this->clinics[] = $clinic;
        }

        return $this;
    }

    public function removeClinic(Clinic $clinic): self
    {
        $this->clinics->removeElement($clinic);

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
            $treatment->addDoctor($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->removeElement($treatment)) {
            $treatment->removeDoctor($this);
        }

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
            $service->addDoctor($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            $service->removeDoctor($this);
        }

        return $this;
    }

    /**
     * @return Collection|Specialty[]
     */
    public function getSpecialties(): Collection
    {
        return $this->specialties;
    }

    public function addSpecialty(Specialty $specialty): self
    {
        if (!$this->specialties->contains($specialty)) {
            $this->specialties[] = $specialty;
        }

        return $this;
    }

    public function removeSpecialty(Specialty $specialty): self
    {
        $this->specialties->removeElement($specialty);

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

    /**
     * @return Collection|PriceItem[]
     */
    public function getPriceItems(): Collection
    {
        return $this->priceItems;
    }

    public function addPriceItem(PriceItem $priceItem): self
    {
        if (!$this->priceItems->contains($priceItem)) {
            $this->priceItems[] = $priceItem;
            $priceItem->addDoctor($this);
        }

        return $this;
    }

    public function removePriceItem(PriceItem $priceItem): self
    {
        if ($this->priceItems->removeElement($priceItem)) {
            $priceItem->removeDoctor($this);
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
            $review->addDoctor($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            $review->removeDoctor($this);
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
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
            $cert->setDoctor($this);
        }

        return $this;
    }

    public function removeCert(Cert $cert): self
    {
        if ($this->certs->removeElement($cert)) {
            // set the owning side to null (unless already changed)
            if ($cert->getDoctor() === $this) {
                $cert->setDoctor(null);
            }
        }

        return $this;
    }

    public function getRating1(): ?DoctorRating
    {
        return $this->rating1;
    }

    public function setRating1(?DoctorRating $rating1): self
    {
        $this->rating1 = $rating1;

        return $this;
    }

    public function getRating2(): ?DoctorRating
    {
        return $this->rating2;
    }

    public function setRating2(?DoctorRating $rating2): self
    {
        $this->rating2 = $rating2;

        return $this;
    }

    public function getAppointment(): ?PriceItem
    {
        return $this->appointment;
    }

    public function setAppointment(?PriceItem $appointment): self
    {
        $this->appointment = $appointment;

        return $this;
    }

    /**
     * @return Collection|DoctorAppointment[]
     */
    public function getDoctorAppointments(): Collection
    {
        return $this->doctorAppointments;
    }

    public function addDoctorAppointment(DoctorAppointment $doctorAppointment): self
    {
        if (!$this->doctorAppointments->contains($doctorAppointment)) {
            $this->doctorAppointments[] = $doctorAppointment;
            $doctorAppointment->setDoctor($this);
        }

        return $this;
    }

    public function removeDoctorAppointment(DoctorAppointment $doctorAppointment): self
    {
        if ($this->doctorAppointments->removeElement($doctorAppointment)) {
            // set the owning side to null (unless already changed)
            if ($doctorAppointment->getDoctor() === $this) {
                $doctorAppointment->setDoctor(null);
            }
        }

        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}
