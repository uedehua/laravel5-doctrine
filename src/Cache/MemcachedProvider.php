<?php

namespace UeDehua\LaravelDoctrine\Cache;

use Doctrine\Common\Cache\MemcachedCache;

/**
 * @author 陈德华 <mr.sk@qq.com>
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/caching.html
 */

class MemcachedProvider implements BaseProvider
{

    public function make($config = null)
    {
        if (!extension_loaded('memcached')) {
            throw new \RuntimeException('Memcached extension was not loaded.');
        }
        $memcached = new \Memcached();
        $memcached->connect($config['host'], $config['port']);
        $cache = new MemcachedCache();
        $cache->setMemcached($memcached);
        return $cache;
    }

    public function getName($provider)
    {
        return $provider == 'memcached';
    }

}
