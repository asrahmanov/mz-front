<?php

namespace App\Controller\Admin;

use App\Entity\SeoRule;
use App\Repository\SeoRuleRepository;
use App\Service\SingularPathSegmentNameGenerator;
use Elastica\Exception\NotFoundException;
use Knp\Component\Pager\PaginatorInterface;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function Symfony\Component\Translation\t;

class SeoRuleController extends AdminController
{
    private ValidatorInterface $validatator;

    public function __construct(
        SingularPathSegmentNameGenerator $pathSegmentNameGenerator,
        MessageBusInterface              $messageBus,
        ValidatorInterface               $validator
    )
    {
        parent::__construct($pathSegmentNameGenerator, $messageBus);
        $this->validatator = $validator;
    }

    protected function getEntityClass()
    {
        return \App\Entity\SeoRule::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\SeoRuleType::class;
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder->add("path", "Путь");
    }

    protected function getIndexTemplate()
    {
        return "admin/entity/seo_rule/index.html.twig";
    }

    public function index(PaginatorInterface $paginator, Request $request,): Response
    {
        $seoRuleRepository = $this->getDoctrine()->getRepository(SeoRule::class);
        $form = $this->createFormBuilder()
            ->add("file", FileType::class, ["required" => true, "label" => "Выберите файл",
                'constraints' => [
                    new File([
                        'mimeTypes' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                        'mimeTypesMessage' => 'Неподдерживаемый формат файла (необходим .xlsx)'
                    ])
                ]])
            ->add("submit", SubmitType::class, ["label" => "Загрузить"])
            ->getForm();
        $form->handleRequest($request);
        $importResult = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            $importResult = $this->import($file, $request, $seoRuleRepository, $this->validatator);
        }
        $entities = $paginator->paginate($this->getQuery(), $request->query->get('page', 1));
        return $this->render($this->getIndexTemplate(), [
            'entities' => $entities,
            'slug' => $this->getSlug(),
            'fields' => $this->indexFields,
            'form' => $form->createView(),
            'importResult' => $importResult,
        ]);
    }

    public function import(
        UploadedFile       $file,
        Request            $request,
        SeoRuleRepository  $seoRuleRepository,
        ValidatorInterface $validator
    )
    {
        $errorItems = [];
        $newItems = [];
        $updatedItems = [];
        $destination = $this->getParameter("temp_directory");
        if (!is_dir($destination)) {
            mkdir($destination);
        }
        $fileName = uniqid() . "." . $file->guessClientExtension();
        $file->move($destination, $fileName);
        $reader = new Xlsx();
        $absolutePath = $this->getParameter("temp_directory") . DIRECTORY_SEPARATOR . $fileName;
        $spreadsheet = $reader->load($absolutePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        for ($i = 1; $i < count($sheetData); $i++) {
            if ($sheetData[$i][0] == null) {
                continue;
            }
            $seoRule = $seoRuleRepository->findOneBy(["path" => $sheetData[$i][0]]);
            if (!$seoRule) {
                $seoRule = new SeoRule();
                $seoRule->setPath($sheetData[$i][0]);
            }
            $seoRule->setTitle($sheetData[$i][1])
                ->setDescription($sheetData[$i][2])
                ->setH1($sheetData[$i][3])
                ->setCanonical($sheetData[$i][4])
                ->setRobots($sheetData[$i][5]);

            $errors = $validator->validate($seoRule);
            if (!$errors->count()) {
                if ($seoRule->getId()) {
                    $updatedItems[] = $seoRule;
                } else {
                    $newItems[] = $seoRule;
                }
                $seoRuleRepository->add($seoRule);
            } else {
                foreach ($errors as $err) {
                    $errorItems[] = $err;
                }
            }

        }
        unlink($absolutePath);

        return [
            'errorItems' => $errorItems,
            'newItems' => $newItems,
            'updatedItems' => $updatedItems,
        ];
    }

    /**
     * @Route("admin/seo_rule/export")
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(): BinaryFileResponse
    {
        $destination = $this->getParameter("temp_directory");
        if (!is_dir($destination)) {
            mkdir($destination);
        }
        $absolutePath = $this->getParameter("temp_directory") . DIRECTORY_SEPARATOR . "seo_rules.xlsx";
        $seo_rules = $this->getDoctrine()->getRepository(SeoRule::class)->findAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet
            ->getActiveSheet()
            ->setCellValue('A1', 'URL')
            ->setCellValue('B1', 'Title')
            ->setCellValue('C1', 'Description')
            ->setCellValue('D1', 'H1')
            ->setCellValue('E1', 'Canonical')
            ->setCellValue('F1', 'Indexing');
        $sn = 2;
        foreach ($seo_rules as $seo_rule) {
            $sheet
                ->setCellValue('A' . $sn, $seo_rule->getPath())
                ->setCellValue('B' . $sn, $seo_rule->getTitle())
                ->setCellValue('C' . $sn, $seo_rule->getDescription())
                ->setCellValue('D' . $sn, $seo_rule->getH1())
                ->setCellValue('E' . $sn, $seo_rule->getCanonical())
                ->setCellValue('F' . $sn, $seo_rule->getRobots());
            $sn++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save($absolutePath);
        $response = new BinaryFileResponse($absolutePath,
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="seo_rules.xlsx"'
            ]);
        $response->deleteFileAfterSend();
        return $response;
    }


}
