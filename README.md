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

## 附加说明

As a result the composer install may require you to change
the `minimum-stability` in your `composer.json` to `dev`.

如果你不想影响其他包的稳定性, 您可以在您的 `composer.json`增加下面的属性:

"prefer-stable": true

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
The little example below shows how to use the EntityManager in it simplest form.

```php
<?php

$user = new User;
$user->setName('Mitchell');

EntityManager::persist($user);
EntityManager::flush();
```

The `User` used in the example above looks like this.

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

If you've only used Eloquent and its models this might look bloated or frightening, but it's actually very simple. Let me break the class down.

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
}
```

The only thing that's actually important in this `entity` are the properties. This shows you which data the `entity` holds.

With Doctrine 2 you can't interact with database by using the entity `User`. You'll have to use [Entity Manager](https://github.com/uedehua/laravel5-doctrine/wiki/Entity-Manager) and `repositories`.
This does create less overhead since your entities aren't extending the whole Eloquent `model` class. Which can dramatically slow down your application a lot if you're working with thousands or millions of records.

## License

This package is licensed under the [MIT license](https://github.com/uedehua/laravel5-doctrine/blob/master/LICENSE).
