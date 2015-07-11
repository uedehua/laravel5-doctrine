<?php

namespace UeDehua\LaravelDoctrine\Cache;

interface Provider
{
    public function make($config = null);
    
    public function isAppropriate($provider);
} 

