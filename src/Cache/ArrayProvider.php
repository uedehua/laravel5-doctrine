<?php

namespace UeDehua\LaravelDoctrine\Cache;

use UeDehua\LaravelDoctrine\Cache\BaseProvider;

/**
 * @author 陈德华 <mr.sk@qq.com>
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/caching.html
 */
class ArrayProvider implements BaseProvider
{
    public function make($config = null)
    {
        return null;
    }
    public function getName($provider)
    {
        return $provider == 'array';
    }
}

