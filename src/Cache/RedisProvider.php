<?php

namespace UeDehua\LaravelDoctrine\Cache;

use Doctrine\Common\Cache\RedisCache;

/**
 * @author 陈德华 <mr.sk@qq.com>
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/caching.html
 */
class RedisProvider implements BaseProvider
{
    public function make($config = null)
    {
        if ( ! extension_loaded('redis')){
            throw new \RuntimeException('Redis extension was not loaded.');
        }
        $redis = new \Redis();
        $redis->connect($config['host'], $config['port']);
        if (isset($config['database'])){
            $redis->select($config['database']);
        }
            
        $cache = new RedisCache();
        $cache->setRedis($redis);
        return $cache;
    }
    public function getName($provider)
    {
        return $provider == 'redis';
    }
}

