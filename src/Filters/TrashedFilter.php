<?php

namespace UeDehua\LaravelDoctrine\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class TrashedFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $metadata, $table)
    {
        $trash  = $this->isSoftDeletable($metadata->rootEntityName);
        if($trash){
            return "{$table}.deleted_at IS NULL OR CURRENT_TIMESTAMP < {$table}.deleted_at";
        }
        return '';
    }

    private function isSoftDeletable($entity)
    {
        $class  = 'UeDehua\LaravelDoctrine\Traits\SoftDeletes';
        return array_key_exists($class, class_uses($entity));
    }

}
