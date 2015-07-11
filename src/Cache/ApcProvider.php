<?php

namespace UeDehua\LaravelDoctrine\Cache;

/**
 * @author 陈德华 <mr.sk@qq.com>
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/caching.html
 */
class ApcProvider implements Provider
{

    public function make($config = null)
    {
        if (!extension_loaded('apc')){
            throw new \RuntimeException('Apc extension was not loaded.');
        }
            
        return new ApcCache();
    }

    public function getName($provider)
    {
        return $provider == 'apc';
    }

}
