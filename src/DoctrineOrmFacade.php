<?php

namespace UeDehua\LaravelDoctrine;

use Illuminate\Support\Facades\Facade;

class DoctrineOrmFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Doctrine\ORM\EntityManager';
    }

}
