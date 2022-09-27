<?php

namespace App\Controller;

use Elastica\Client;
use Elastica\QueryBuilder;
use Elastica\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AutocompleteController extends AbstractController
{
    private Search $search;
    private QueryBuilder $queryBuilder;
    private Request $request;
    private array $query = [];

    public function __construct(RequestStack $requestStack, Client $elasticaClient)
    {
        $this->queryBuilder = new QueryBuilder();
        $this->search = new Search($elasticaClient);
        $this->request = $requestStack->getCurrentRequest();
        if ($json = json_decode($this->request->getContent(), true)) {
            $this->query = $json;
        }
    }

    /**
     * @Route("/autocomplete/doctors", name="autocomplete.doctors")
     * @return Response
     */
    public function doctors(): Response
    {
        $query = $this->queryBuilder->query()->bool();

        if (! empty($this->query['name'])) {
            $query->addMust(
                $this->queryBuilder->query()->query_string($this->query['name'] ?? null)
            );
        }
        if (! empty($this->query['clinicId'])) {
            $query->addMust(
                $this->queryBuilder->query()->term(['clinicIds' => $this->query['clinicId']] ?? null)
            );
        }

        $resultSet = $this->search->addIndex('doctors')->search($query);
        $result = [];
        foreach ($resultSet as $resultItem) {
            $result[] = $resultItem->getData();
        }

        return $this->render('autocomplete/autocomplele.html.twig', [
            'result' => $result,
        ]);
    }

    /**
     * @Route("/autocomplete/services", name="autocomplete.services")
     * @return Response
     */
    public function services(): Response
    {
        $query = $this->queryBuilder->query()->bool();
        if (! empty($this->query['name'])) {
            $query->addMust(
                $this->queryBuilder->query()->query_string($this->query['name'] ?? null)
            );
        }
        if (! empty($this->query['clinicId'])) {
            $query->addMust(
                $this->queryBuilder->query()->term(['clinicIds' => $this->query['clinicId']] ?? null)
            );
        }

        $resultSet = $this->search->addIndex('services')->search($query);
        $result = [];
        foreach ($resultSet as $resultItem) {
            $result[] = $resultItem->getData();
        }

        return $this->render('autocomplete/autocomplele.html.twig', [
            'result' => $result,
        ]);
    }

    /**
     * @Route("/autocomplete/diseases", name="autocomplete.diseases")
     * @return Response
     */
    public function diseases(): Response
    {
        $query = $this->queryBuilder->query()->bool();
        if (! empty($this->query['name'])) {
            $query->addMust(
                $this->queryBuilder->query()->query_string($this->query['name'] ?? null)
            );
        }

        $resultSet = $this->search->addIndex('diseases')->search($query);
        $result = [];
        foreach ($resultSet as $resultItem) {
            $result[] = $resultItem->getData();
        }

        return $this->render('autocomplete/autocomplele.html.twig', [
            'result' => $result,
        ]);
    }

    /**
     * @Route("/autocomplete/main", name="autocomplete.main")
     */
    public function main()
    {
        $query = $this->queryBuilder->query()->bool();
        if (! empty($this->query['query'])) {
            $query->addMust(
                $this->queryBuilder->query()->query_string($this->query['query'])
            );
        }
        $resultSet = $this->search->search($query);
        $result = [];
        foreach ($resultSet as $resultItem) {
            $result[] = $resultItem->getData();
        }

        return $this->render('autocomplete/autocomplele.html.twig', [
            'result' => $result,
        ]);
    }
}
