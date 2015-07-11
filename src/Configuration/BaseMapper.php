<?php

namespace UeDehua\LaravelDoctrine\Configuration;

/**
 * @author 陈德华 <mr.sk@qq.com>
 */
interface BaseMapper
{

    /**
     * Handles the mapping of configuration.
     *
     * @param array $configuration
     * @return mixed
     */
    public function map(array $configuration);

    /**
     * Determines whether the configuration array is appropriate for the mapper.
     *
     * @param array $configuration
     * @return mixed
     */
    public function supports(array $configuration);
}
