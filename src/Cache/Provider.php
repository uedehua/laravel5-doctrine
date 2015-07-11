<?php

namespace UeDehua\LaravelDoctrine\Cache;

interface Provider
{
    public function make($config = null);
    
    public function getName($provider);
} 

