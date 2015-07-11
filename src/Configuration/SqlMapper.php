<?php

namespace UeDehua\LaravelDoctrine\Configuration;

use UeDehua\LaravelDoctrine\Configuration\BaseMapper;
/**
 * @author 陈德华 <mr.sk@qq.com>
 */
class SqlMapper implements BaseMapper
{

    /**
     * 创建配置映射SQL数据库引擎
     *
     * @param array $config
     * @return array
     */
    public function map(array $config)
    {
        return [
            'driver' => $this->driver($config['driver']),
            'host' => $config['host'],
            'dbname' => $config['database'],
            'user' => $config['username'],
            'password' => $config['password'],
            'charset' => $config['charset'],
            'prefix' => $config['prefix'] ? $config['prefix'] : null
        ];
    }

    /**
     * 适用于Mysql映射配置
     *
     * @param array $config
     * @return boolean
     */
    public function supports(array $config)
    {
        return in_array($config['driver'], ['mysql']);
    }

    /**
     * 映射Laravel到Sql.
     *
     * @param $driver
     * @return string
     */
    public function driver($driver)
    {
        $drivers = ['mysql' => 'pdo_mysql'];
        return $drivers[$driver];
    }

}
