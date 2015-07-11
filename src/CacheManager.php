<?php

use UeDehua\LaravelDoctrine\Cache\Provider;

class CacheManager
{

    private $providers = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 缓存句柄
     * @param string $type array,memcache,memcached,redis,xcache
     * @return \Doctrine\Common\Cache\CacheProvider
     */
    public function getCache($type)
    {
        foreach ($this->providers as $provider) {
            if ($provider->getName($type)) {
                return $provider->make($this->getConfig($type));
            }
        }
        return null;
    }

    private function getConfig($provider)
    {
        return isset($this->config[$provider]) ? $this->config[$provider] : null;
    }

    public function add(Provider $provider)
    {
        $this->providers[] = $provider;
    }

}
