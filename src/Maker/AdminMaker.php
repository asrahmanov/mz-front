<?php

namespace App\Maker;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\MakerBundle\Str;
use \Symfony\Component\Console\Command\Command;
use \Symfony\Bundle\MakerBundle\InputConfiguration;
use \Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Bundle\MakerBundle\ConsoleStyle;
use \Symfony\Bundle\MakerBundle\Generator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Yaml\Yaml;

class AdminMaker extends \Symfony\Bundle\MakerBundle\Maker\AbstractMaker
{
    private $em;
    private $kernel;

    public function __construct(EntityManagerInterface $em, KernelInterface $kernel)
    {
        $this->em = $em;
        $this->kernel = $kernel;
    }

    public static function getCommandName(): string
    {
        return 'make:admin';
    }

    public static function getCommandDescription(): string
    {
        return 'Create admin section';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->addArgument('bound-class', InputArgument::REQUIRED, 'The name of Entity or fully qualified model class name that the new form will be bound to (empty for none)')
            ->addOption('type-name', null, InputOption::VALUE_OPTIONAL)
            ->addOption('controller-name', null, InputOption::VALUE_OPTIONAL)
        ;
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            AbstractType::class,
            // technically only form is needed, but the user will *probably* also want validation
            'form'
        );

        $dependencies->addClassDependency(
            Validation::class,
            'validator',
            // add as an optional dependency: the user *probably* wants validation
            false
        );

        $dependencies->addClassDependency(
            DoctrineBundle::class,
            'orm',
            false
        );
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $entityClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('bound-class'),
            'Entity\\'
        );

        $typeClassNameDetails =  $generator->createClassNameDetails(
            $input->getOption('type-name') ?? $entityClassNameDetails->getShortName(),
            'Form\\Admin',
            'Type'
        );

        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $io->text('type: ' . $typeClassNameDetails->getFullName());

        $application->run(new ArrayInput([
            'command' => 'make:form',
            'name' => 'Admin\\' . $typeClassNameDetails->getShortName(),
            'bound-class' => $entityClassNameDetails->getShortName(),
        ]));

        $controllerClassNameDetails = $generator->createClassNameDetails(
            $input->getOption('controller-name') ?? $entityClassNameDetails->getShortName(),
            'Controller\\Admin\\',
            'Controller'
        );

        $generator->generateClass(
            $controllerClassNameDetails->getFullName(),
            'src/Maker/Resources/skeleton/admin/Controller.tpl.php',
            [
                'entityName' => '\\' . $entityClassNameDetails->getFullName(),
                'typeName' => '\\' . $typeClassNameDetails->getFullName(),
            ]
        );

        $generator->writeChanges();

        $converter = new CamelCaseToSnakeCaseNameConverter();
        $slug = $converter->normalize($controllerClassNameDetails->getRelativeNameWithoutSuffix());

        $routes = [
            $slug => [
                'path' => '/' . $slug,
                'controller' => '\\' . $controllerClassNameDetails->getFullName() . '::index',
                'methods' => 'GET'
            ],
            $slug . '.create' => [
                'path' => '/' . $slug . '/create',
                'controller' => '\\' . $controllerClassNameDetails->getFullName() . '::create',
                'methods' => 'GET|POST'
            ],
            $slug . '.edit' => [
                'path' => '/' . $slug . '/edit/{id}',
                'controller' => '\\' . $controllerClassNameDetails->getFullName() . '::edit',
                'methods' => 'GET|POST'
            ],
            $slug . '.delete' => [
                'path' => '/' . $slug . '/delete/{id}',
                'controller' => '\\' . $controllerClassNameDetails->getFullName() . '::delete',
                'methods' => 'POST'
            ],
        ];

        $yaml = Yaml::dump($routes);

        $result = file_put_contents('config/routes/admin/' . $slug . '.yaml', $yaml);

        $io->success('SUCCESS');
    }
}
