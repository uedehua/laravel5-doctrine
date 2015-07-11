<?php

namespace UeDehua\LaravelDoctrine\Cache;

class ApcProvider implements Provider
{

    public function make($config = null)
    {
        if (!extension_loaded('apc')){
            throw new \RuntimeException('Apc extension was not loaded.');
        }
            
        return new ApcCache();
    }

    public function isAppropriate($provider)
    {
        return $provider == 'apc';
    }

}