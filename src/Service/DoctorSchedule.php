<?php

namespace App\Service;

use App\Entity\Doctor;
use App\Repository\DoctorScheduleDateRepository;

class DoctorSchedule
{
    private DoctorScheduleDateRepository $dateRepo;

    public function __construct(DoctorScheduleDateRepository $dateRepository)
    {
        $this->dateRepo = $dateRepository;
    }

    public function getNearestDate(Doctor $doctor): ?\DateTime
    {
        $date = $this->dateRepo->findNearestReceptionDate($doctor);
        return $date ? $date->getDate() : null;
    }
}
