<?php


namespace App\Controller\Admin;


use App\Message\EntityCreated;
use App\Message\EntityDeleted;
use App\Message\EntityUpdated;
use App\Service\SingularPathSegmentNameGenerator;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AdminController extends AbstractController
{
    protected SingularPathSegmentNameGenerator $pathSegmentNameGenerator;
    protected array $indexFields;
    private MessageBusInterface $messageBus;

    abstract protected function getEntityClass();
    abstract protected function getForm();

    public function __construct(
        SingularPathSegmentNameGenerator $pathSegmentNameGenerator,
        MessageBusInterface $messageBus
    )
    {
        $this->messageBus = $messageBus;
        $this->pathSegmentNameGenerator = $pathSegmentNameGenerator;
        $indexFieldBuilder = new IndexFieldsBuilder();
        static::setIndexFields($indexFieldBuilder);
        $this->indexFields = $indexFieldBuilder->getFieldsArray();
    }

    protected function setIndexFields(IndexFieldsBuilder $builder) {}

    protected function getCreateForm()
    {
        return $this->getEditForm();
    }

    protected function getEditForm()
    {
        return $this->getForm();
    }

    protected function getIndexTemplate()
    {
        return "admin/entity/default/index.html.twig";
    }

    protected function getEditTemplate()
    {
        return "admin/entity/default/create.html.twig";
    }

    protected function getCreateTemplate()
    {
        return "admin/entity/default/create.html.twig";
    }

    protected function getSlug()
    {
        $reflection = new \ReflectionClass($this->getEntityClass());
        return $this->pathSegmentNameGenerator->getSegmentName($reflection->getShortName());
    }

    protected function createEntity()
    {
        $entityClass = $this->getEntityClass();
        return $entity = new $entityClass;
    }

    protected function getQuery()
    {
        $qb = $this->getDoctrine()
            ->getRepository($this->getEntityClass())
            ->createQueryBuilder($this->getSlug())
            ->addOrderBy($this->getSlug().'.id', 'desc')
        ;
        $qb = $this->addQuery($qb);
        return $qb->getQuery();
    }

    protected function addQuery(QueryBuilder $queryBuilder)
    {
        return $queryBuilder;
    }

    public function getEntity($id)
    {
        $entity = $this->getDoctrine()->getRepository($this->getEntityClass())->find($id);
        if (! $entity) throw new UnprocessableEntityHttpException();
        return $entity;
    }

    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $entities = $paginator->paginate($this->getQuery(), $request->query->get('page', 1));
        return $this->render($this->getIndexTemplate(), [
            'entities' => $entities,
            'slug' => $this->getSlug(),
            'fields' => $this->indexFields,
        ]);
    }

    public function edit($id, Request $request, ValidatorInterface $validator): Response
    {
        $entity = $this->getEntity($id);

        $form = $this->createForm($this->getEditForm(), $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $this->getDoctrine()->getManager()->persist($entity);
            $this->getDoctrine()->getManager()->flush();
            $this->messageBus->dispatch(new EntityUpdated(get_class($entity), $entity->getId()));
            return $this->redirectToRoute("admin.{$this->getSlug()}");
        }

        return $this->render($this->getEditTemplate(), [
            'form' => $form->createView(),
            'action' => $this->generateUrl("admin.{$this->getSlug()}.create"),
            'slug' => $this->getSlug(),
        ]);
    }

    public function delete($id, Request $request): Response
    {
        $entity = $this->getEntity($id);

        $this->getDoctrine()->getManager()->remove($entity);
        $this->messageBus->dispatch(new EntityDeleted(get_class($entity), $entity->getId()));
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("admin.{$this->getSlug()}");
    }

    public function create(Request $request): Response
    {
        $entity = $this->createEntity();
        $form = $this->createForm($this->getCreateForm(), $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $this->getDoctrine()->getManager()->persist($entity);
            $this->getDoctrine()->getManager()->flush();
            $this->messageBus->dispatch(new EntityCreated(get_class($entity), $entity->getId()));
            return $this->redirectToRoute("admin.{$this->getSlug()}");
        }
        return $this->render($this->getCreateTemplate(), [
            'form' => $form->createView(),
            'action' => $this->generateUrl("admin.{$this->getSlug()}.create"),
            'slug' => $this->getSlug(),
        ]);
    }
}
