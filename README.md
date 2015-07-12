# Doctrine 2 for Laravel5

[![Latest Stable Version](https://poser.pugx.org/uedehua/laravel5-doctrine/version.png)](https://packagist.org/packages/uedehua/laravel5-doctrine)
[![License](https://poser.pugx.org/uedehua/laravel5-doctrine/license.png)](https://packagist.org/packages/uedehua/laravel5-doctrine)
[![Total Downloads](https://poser.pugx.org/uedehua/laravel5-doctrine/downloads.png)](https://packagist.org/packages/uedehua/laravel5-doctrine)

A Doctrine 2 implementation that melts with Laravel 5.1.X.

## Documentation

Begin reading [the full documentation](https://github.com/uedehua/laravel5-doctrine/wiki) here or go to a specific chapter right away.

1. [安装](https://github.com/uedehua/laravel5-doctrine/wiki/Installation)
2. [ 它是如何工作的](https://github.com/uedehua/laravel5-doctrine/wiki/How-It-Works)
  1. [基础](https://github.com/uedehua/laravel5-doctrine/wiki/Basics)
  2. [实体管理](https://github.com/uedehua/laravel5-doctrine/wiki/Entity-Manager)
  3. [Timestamps Trait](https://github.com/uedehua/laravel5-doctrine/wiki/Timestamps)
  4. [SoftDelete Trait](https://github.com/uedehua/laravel5-doctrine/wiki/Soft-Deleting)
  5. [Authentication Trait](https://github.com/uedehua/laravel5-doctrine/wiki/Authentication)
3. [Schemas](https://github.com/uedehua/laravel5-doctrine/wiki/Schemas)
4. [Doctrine 配置](https://github.com/uedehua/laravel5-doctrine/wiki/Doctrine-Configuration)
  1. [元数据 配置](https://github.com/uedehua/laravel5-doctrine/wiki/Metadata-Configuration)
  2. [读取注释](https://github.com/uedehua/laravel5-doctrine/wiki/Annotation-Reader)
  3. [元数据](https://github.com/uedehua/laravel5-doctrine/wiki/Metadata)
5. [MIT License](https://github.com/uedehua/laravel5-doctrine/blob/master/LICENSE)


## 安装

修改项目的 `composer.json` 文件,添加 `uedehua/laravel5-doctrine`

```php
"require": {
    "uedehua/laravel5-doctrine": "5.1.*"
}
```

执行composer更新:

```php
php composer update
```

添加provider,打开 `app/config/app.php` 配置文件, 在`providers`数组添加一行.

```php
'UeDehua\LaravelDoctrine\Provider\DoctrineOrmProvider'
```

添加Facade. 打开 `app/config/app.php` 配置文件, 在`aliases`数组添加一行.

```php
'DoctrineOrm' => 'UeDehua\LaravelDoctrine\Facade\DoctrineOrm'
```

别忘记发布你的配置.

```php
php artisan config:publish uedehua/laravel5-doctrine --path=vendor/uedehua/laravel5-doctrine/config
```

## 2 Minutes

这个包使用 Laravel5 本身的数据库配置, 通过 [Entity Manager](https://github.com/uedehua/laravel5-doctrine/wiki/Entity-Manager) facade (or service locator) 与数据库进行交互.
请参阅 [Doctrine 2](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/index.html) 文档.
下面的小例子展示了如何在它最简单的形式使用Doctrine ORM.

```php
<?php

$user = new User;
$user->setName('Mitchell');

EntityManager::persist($user);
EntityManager::flush();
```

添加一个用户到数据库.

```php
<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hk_user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
```

User实体基于Annotation，更多请参阅官方文档。

## License

This package is licensed under the [MIT license](https://github.com/uedehua/laravel5-doctrine/blob/master/LICENSE).
