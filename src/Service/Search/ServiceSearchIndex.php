<?php

namespace App\Service\Search;

use App\Entity\Doctor;
use App\Entity\Service;
use Elasticsearch\Client;
use Symfony\Component\Routing\RouterInterface;

class ServiceSearchIndex implements SearchIndexInterface
{
    private Client $client;
    private RouterInterface $router;

    const INDEX_NAME = 'services';

    public function __construct(Client $client, RouterInterface $router)
    {
        $this->client = $client;
        $this->router = $router;
    }

    public function put($object)
    {
        if (! $object instanceof Service) {
            throw new \Exception('object must be instance of ' . Service::class);
        }

        if (! $this->client->indices()->exists(['index' => self::INDEX_NAME])) {
            $this->createIndex();
        }

        $doc = [
            'index' => self::INDEX_NAME,
            'id' => $object->getId(),
            'body' => [
                'name' => $object->getName(),
                'url' => $this->router->generate('service.show', ['path' => $object->getPath()]),
                'clinicIds' => $object->getClinics()->map(function ($clinic) {
                    return $clinic->getId();
                })->toArray(),
                'template' => 'autocomplete/services.html.twig'
            ],
        ];
        $this->client->index($doc);
    }

    public function delete($object)
    {
        $this->client->delete([
            'id' => $object->getId(),
            'index' => self::INDEX_NAME
        ]);
    }

    public function createIndex()
    {
        $this->client->indices()->create(
            [
                'index' => self::INDEX_NAME,
                'body' => [
                    'settings' => [
                        'number_of_shards' => 1,
                        'number_of_replicas' => 0,
                        "analysis" => [
                            "analyzer" => [
                                "autocomplete" => [
                                    "tokenizer" => "autocomplete",
                                    "filter" => ["lowercase"]
                                ]
                            ],
                            "tokenizer" => [
                                "autocomplete" => [
                                    "type" => "edge_ngram",
                                    "min_gram" => 2,
                                    "max_gram" => 20,
                                    "token_chars" => [
                                        "letter",
                                        "digit"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "mappings" => [
                        "properties" => [
                            "name" => [
                                "type" => "text",
                                "analyzer" => "autocomplete",
                                "search_analyzer" => "standard"
                            ],
                            'clinicIds' => [
                                'type' => 'integer',
                            ]
                        ]
                    ]
                ]
            ]
        );
    }
}
