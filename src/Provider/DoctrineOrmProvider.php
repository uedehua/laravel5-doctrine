<?php

use App;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\Tools\Setup;
use Auth;
use Illuminate\Support\ServiceProvider;
use UeDehua\LaravelDoctrine\Cache\ApcProvider;
use UeDehua\LaravelDoctrine\Cache\MemcacheProvider;
use UeDehua\LaravelDoctrine\Cache\RedisProvider;
use UeDehua\LaravelDoctrine\Cache\XcacheProvider;
use UeDehua\LaravelDoctrine\Cache\ArrayProvider;
use UeDehua\LaravelDoctrine\Configuration\LaravelNamingStrategy;
use UeDehua\LaravelDoctrine\Configuration\Mapper\SqlMapper;
use UeDehua\LaravelDoctrine\EventListeners\SoftDeletableListener;
use UeDehua\LaravelDoctrine\EventListeners\TablePrefix;
use UeDehua\LaravelDoctrine\Filters\TrashedFilter;
use UeDehua\LaravelDoctrine\Validation\DoctrinePresenceVerifier;

class LaravelDoctrineServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->publishes('uedehua/laravel5-doctrine', 'doctrine', __DIR__ . '/..');
        $this->extendAuthManager();
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->registerConfigurationMapper();
        $this->registerCacheManager();
        $this->registerEntityManager();
        $this->registerClassMetadataFactory();
        $this->registerValidationVerifier();
        $this->commands([
            'UeDehua\LaravelDoctrine\Console\GenerateProxiesCommand',
            'UeDehua\LaravelDoctrine\Console\SchemaCreateCommand',
            'UeDehua\LaravelDoctrine\Console\SchemaUpdateCommand',
            'UeDehua\LaravelDoctrine\Console\SchemaDropCommand'
        ]);
    }

    /**
     * The driver mapper's instance needs to be accessible from anywhere in the application,
     * for registering new mapping configurations or other storage libraries.
     */
    private function registerConfigurationMapper()
    {
        $this->app->bind(DriverMapper::class, function () {
            $mapper = new DriverMapper();
            $mapper->registerMapper(new SqlMapper());
            return $mapper;
        });
    }

    /**
     * Registers a new presence verifier for Laravel 5 validation. Specifically, this
     * is for the use of the Doctrine ORM.
     */
    public function registerValidationVerifier()
    {
        $this->app->bindShared('validation.presence', function() {
            return new DoctrinePresenceVerifier(EntityManagerInterface::class);
        });
    }

    public function registerCacheManager()
    {
        $this->app->bind(CacheManager::class, function ($app) {
            $manager = new CacheManager($app['config']['doctrine::doctrine.cache']);
            $manager->add(new ApcProvider());
            $manager->add(new MemcacheProvider());
            $manager->add(new RedisProvider());
            $manager->add(new XcacheProvider());
            $manager->add(new ArrayProvider());
            return $manager;
        });
    }

    private function registerEntityManager()
    {
        $this->app->singleton('DoctrineOrm', function ($app) {
            $config = $app['config']['doctrine::doctrine'];
            $metadata = Setup::createAnnotationMetadataConfiguration(
                            $config['metadata'], $app['config']['app.debug'],
                    $config['proxy']['directory'], $app[CacheManager::class]->getCache($config['cache_provider']),
                    $config['simple_annotations']
            );
            
            $metadata->addFilter('trashed', TrashedFilter::class);
            $metadata->setAutoGenerateProxyClasses($config['proxy']['auto_generate']);
            $metadata->setDefaultRepositoryClassName($config['repository']);
            $metadata->setSQLLogger($config['logger']);
            $metadata->setNamingStrategy($app->make(LaravelNamingStrategy::class));
            
            if (isset($config['proxy']['namespace'])){
                $metadata->setProxyNamespace($config['proxy']['namespace']);
            }
            $eventManager = new EventManager();
            $connection_config = $this->mapLaravelToDoctrineConfig($app['config']);
            
            //load prefix listener
            if (isset($connection_config['prefix'])) {
                $tablePrefix = new TablePrefix($connection_config['prefix']);
                $eventManager->addEventListener(Events::loadClassMetadata, $tablePrefix);
            }
            
            $eventManager->addEventListener(Events::onFlush, new SoftDeletableListener());
            $entityManager = EntityManager::create($connection_config, $metadata, $eventManager);
            $entityManager->getFilters()->enable('trashed');
            
            return $entityManager;
        });
        //$this->app->alias('DoctrineOrm', EntityManagerInterface::class);
    }

    private function registerClassMetadataFactory()
    {
        $this->app->singleton(ClassMetadataFactory::class, function ($app) {
            return $app[EntityManager::class]->getMetadataFactory();
        });
    }

    private function extendAuthManager()
    {
        Auth::extend('doctrine', function ($app) {
            return new DoctrineUserProvider(
                    $app['Illuminate\Contracts\Hashing\Hasher'], $app[EntityManager::class], $app['config']['auth.model']
            );
        });
    }

    /**
     * Map Laravel's to Doctrine's database configuration requirements.
     * @param $config
     * @throws Exception
     * @return array
     */
    private function mapLaravelToDoctrineConfig($config)
    {
        $default = $config['database.default'];
        $connection = $config["database.connections.{$default}"];
        return App::make(DriverMapper::class)->map($connection);
    }

}
