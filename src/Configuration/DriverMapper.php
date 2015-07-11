<?php

use UeDehua\LaravelDoctrine\Configuration\Mapper;

class DriverMapper
{

    /**
     * 数组映射器,可以通过确定循环映射器是适合一个给定的配置
     *
     * @var array
     */
    private $mappers = [];

    /**
     * 注册一个新的驱动程序配置映射器.
     *
     * @param \UeDehua\LaravelDoctrine\Configuration\Mapper $mapper
     */
    public function registerMapper(Mapper $mapper)
    {
        $this->mappers[] = $mapper;
    }

    /**
     * 映射Laravel配置到一个数据库配置
     *
     * @param $configuration
     * @return array
     * @throws Exception
     */
    public function map($configuration)
    {
        foreach ($this->mappers as $mapper) {
            if ($mapper->supports($configuration)) {
                return $mapper->map($configuration);
            }
        }

        throw new \Exception("Driver {$configuration['driver']} unsupported by package at this time.");
    }

}
