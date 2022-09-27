<?php

namespace App\Doctrine\Type;

use \Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use \Symfony\Component\HttpFoundation\File\UploadedFile;

class MyFileType extends \Doctrine\DBAL\Types\Type
{
    public function getName()
    {
        return 'myfile';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getClobTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UploadedFile) {
            $value = $value->getClientOriginalName();
        }
        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UploadedFile($_SERVER['DOCUMENT_ROOT'] . '/uploads/606cb3df29bba.jpg', '606cb3df29bba.jpg');
    }
}
