<?php

namespace UeDehua\LaravelDoctrine\Cache;

use Doctrine\Common\Cache\MemcacheCache;
use UeDehua\LaravelDoctrine\Cache\BaseProvider;

/**
 * @author 陈德华 <mr.sk@qq.com>
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/caching.html
 */

class MemcacheProvider implements BaseProvider
{

    public function make($config = null)
    {
        if (!extension_loaded('memcache')) {
            throw new \RuntimeException('Memcache extension was not loaded.');
        }
        $memcache = new \Memcache();
        $memcache->connect($config['host'], $config['port']);
        $cache = new MemcacheCache();
        $cache->setMemcache($memcache);
        return $cache;
    }

    public function getName($provider)
    {
        return $provider == 'memcache';
    }

}
