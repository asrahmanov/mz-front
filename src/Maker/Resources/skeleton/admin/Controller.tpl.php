<?= "<?php\n"; ?>

namespace <?= $namespace; ?>;

class <?= $class_name; ?> extends AdminController
{
    protected function getEntityClass()
    {
        return <?= $entityName ?>::class;
    }

    protected function getForm()
    {
        return <?= $typeName ?>::class;
    }
}
