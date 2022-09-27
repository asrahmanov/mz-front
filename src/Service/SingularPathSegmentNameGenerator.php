<?php


namespace App\Service;


use ApiPlatform\Core\Operation\PathSegmentNameGeneratorInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class SingularPathSegmentNameGenerator implements PathSegmentNameGeneratorInterface
{
    public function getSegmentName(string $name, bool $collection = true): string
    {
        return $this->dashize($name);
    }

    private function dashize(string $string): string
    {
        $converter = new CamelCaseToSnakeCaseNameConverter();
        return $converter->normalize($string);
    }
}
