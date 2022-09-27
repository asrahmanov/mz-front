<?php

namespace App\Service\Search;

use Psr\Container\ContainerInterface;

class SearchIndex
{
    private ContainerInterface $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public function put($object)
    {
        if (! $this->locator->has(get_class($object))) {
            return null;
        }
        $index = $this->locator->get(get_class($object));
        $index->put($object);
    }

    public function delete($object)
    {
        if (! $this->locator->has(get_class($object))) {
            return null;
        }
        $index = $this->locator->get(get_class($object));
        $index->delete($object);
    }
}
