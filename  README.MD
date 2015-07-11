# Doctrine 2 for Laravel

[![Latest Stable Version](https://poser.pugx.org/uedehua/laravel5-doctrine/version.png)](https://packagist.org/packages/uedehua/laravel5-doctrine)
[![License](https://poser.pugx.org/uedehua/laravel5-doctrine/license.png)](https://packagist.org/packages/uedehua/laravel5-doctrine)
[![Total Downloads](https://poser.pugx.org/uedehua/laravel5-doctrine/downloads.png)](https://packagist.org/packages/uedehua/laravel5-doctrine)

A Doctrine 2 implementation that melts with Laravel 5.1.X.

## Documentation

Begin reading [the full documentation](https://github.com/uedehua/laravel5-doctrine/wiki) here or go to a specific chapter right away.

1. [Installation](https://github.com/uedehua/laravel5-doctrine/wiki/Installation)
2. [How It Works](https://github.com/uedehua/laravel5-doctrine/wiki/How-It-Works)
  1. [Basics](https://github.com/uedehua/laravel5-doctrine/wiki/Basics)
  2. [Entity Manager](https://github.com/uedehua/laravel5-doctrine/wiki/Entity-Manager)
  3. [Timestamps](https://github.com/uedehua/laravel5-doctrine/wiki/Timestamps)
  4. [Soft Deleting](https://github.com/uedehua/laravel5-doctrine/wiki/Soft-Deleting)
  5. [Authentication](https://github.com/uedehua/laravel5-doctrine/wiki/Authentication)
3. [Schemas](https://github.com/uedehua/laravel5-doctrine/wiki/Schemas)
4. [Doctrine Configuration](https://github.com/uedehua/laravel5-doctrine/wiki/Doctrine-Configuration)
  1. [Metadata Configuration](https://github.com/uedehua/laravel5-doctrine/wiki/Metadata-Configuration)
  2. [Annotation Reader](https://github.com/uedehua/laravel5-doctrine/wiki/Annotation-Reader)
  3. [Metadata](https://github.com/uedehua/laravel5-doctrine/wiki/Metadata)
5. [MIT License](https://github.com/uedehua/laravel5-doctrine/blob/master/LICENSE)

## Caveats

As a result the composer install may require you to change
the `minimum-stability` in your `composer.json` to `dev`.

如果你不想影响其他包的稳定性, 您可以在您的 `composer.json`增加下面的属性:

"prefer-stable": true

## 安装

通过Composer安装之前,编辑你项目的 `composer.json` 文件,添加 `uedehua/laravel5-doctrine`.

> 这个代码还处于早期阶段，但功能齐全。可以预料会有一些小得变化，不会有大得变动.

```php
"require": {
    "uedehua/laravel5-doctrine": "5.1.*"
}
```

接下来，通过Composer命令更新你得项目:

```php
php composer update
```

一旦安装了包，您需要添加服务供应商. 打开项目 `app/config/app.php` 配置文件, 在`providers`数组内添加新的项目.

```php
'UeDehua\LaravelDoctrine\Provider\DoctrineOrmProvider'
```

接下来添加Facade. 打开 `app/config/app.php` 配置文件, 在`aliases`数组内添加新的项目.

```php
'DoctrineOrm' => 'UeDehua\LaravelDoctrine\Facade\DoctrineOrm'
```

别忘记发布你的配置.

```php
php artisan config:publish uedehua/laravel5-doctrine --path=vendor/uedehua/laravel5-doctrine/config
```

## 2 Minutes

This package uses the Laravel database configuration and thus it works right out of the box. With the [Entity Manager](https://github.com/uedehua/laravel5-doctrine/wiki/Entity-Manager) facade (or service locator) you can interact with repositories.
It might be wise to [check out the Doctrine 2 docs](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/index.html) to know how it works.
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
