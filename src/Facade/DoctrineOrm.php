<?php

namespace UeDehua\LaravelDoctrine\Facade;

use Illuminate\Support\Facades\Facade;

class DoctrineOrm extends Facade
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
