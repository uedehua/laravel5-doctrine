<?php

namespace UeDehua\LaravelDoctrine\Cache;

interface BaseProvider
{
    public function make($config = null);
    
    public function getName($provider);
} 

