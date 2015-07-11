<?php

namespace UeDehua\LaravelDoctrine\Cache;

use Doctrine\Common\Cache\XcacheCache;

/**
 * @author 陈德华 <mr.sk@qq.com>
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/caching.html
 */
class XcacheProvider implements Provider
{
    public function make($config = null)
    {
        if ( ! extension_loaded('xcache'))
        {
            throw new \RuntimeException('Xcache extension was not loaded.');
        }
            
        return new XcacheCache();
    }
    public function getName($provider)
    {
        return $provider == 'xcache';
    }
}
