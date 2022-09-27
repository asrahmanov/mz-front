<?php

namespace App\Command;

use App\Repository\DiseaseRepository;
use App\Repository\DoctorRepository;
use App\Repository\ServiceRepository;
use App\Service\Search\SearchIndex;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateIndicesCommand extends Command
{
    protected static $defaultName = 'app:create-indices';
    protected static $defaultDescription = 'Add a short description for your command';

    private SearchIndex $searchIndex;
    private DoctorRepository $doctorRepository;
    private ServiceRepository $serviceRepository;
    private DiseaseRepository $diseaseRepository;

    public function __construct(
        SearchIndex $searchIndex,
        DoctorRepository $doctorRepository,
        ServiceRepository $serviceRepository,
        DiseaseRepository $diseaseRepository
    )
    {
        parent::__construct();
        $this->searchIndex = $searchIndex;
        $this->doctorRepository = $doctorRepository;
        $this->serviceRepository = $serviceRepository;
        $this->diseaseRepository = $diseaseRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->indexDoctors();
        $io->success('Doctors index created.');

        $this->indexServices();
        $io->success('Services index created.');

        $this->indexDiseases();
        $io->success('Diseases index created.');

        return Command::SUCCESS;
    }

    private function indexDoctors()
    {
        $doctors = $this->doctorRepository->findAll();
        foreach ($doctors as $doctor) {
            $this->searchIndex->put($doctor);
        }
    }

    private function indexServices()
    {
        $services = $this->serviceRepository->findAll();
        foreach ($services as $service) {
            $this->searchIndex->put($service);
        }
    }

    private function indexDiseases()
    {
        $diseases = $this->diseaseRepository->findAll();
        foreach ($diseases as $disease) {
            $this->searchIndex->put($disease);
        }
    }
}
