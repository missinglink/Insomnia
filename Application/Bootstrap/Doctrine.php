<?php

namespace Application\Bootstrap;

use \Doctrine\Common\ClassLoader,
    \Doctrine\ORM\Mapping\Driver\DriverChain,
    \Doctrine\ORM\EntityManager,
    \Doctrine\ORM\Configuration,
    \Doctrine\Common\Cache\ArrayCache,
    \Doctrine\Common\Cache\ApcCache;

class Doctrine extends EntityManager
{
    public static $em;

    public function __construct()
    {
        // Autoloader (1)
        $classLoader = new ClassLoader( 'Entities', __DIR__ . '../' );
        $classLoader->register();
        $classLoader = new ClassLoader( 'Proxies', __DIR__ . '../' );
        $classLoader->register();

        // configuration (2)
        $config = new Configuration;

        // Proxies (3)
        $config->setProxyDir( __DIR__ . '../Proxies' );
        $config->setProxyNamespace( 'Proxies' );
        $config->setAutoGenerateProxyClasses( APPLICATION_ENV === 'development' );

        // Driver (4)
        $driverImpl = $config->newDefaultAnnotationDriver( array( __DIR__. '/../Entities' ) );
        $config->setMetadataDriverImpl($driverImpl);

        // Caching Configuration (5)
        $cache = ( APPLICATION_ENV === 'development' )
            ? new \Doctrine\Common\Cache\ArrayCache
            : new \Doctrine\Common\Cache\ApcCache;

        $config->setMetadataCacheImpl( $cache );
        $config->setQueryCacheImpl( $cache );

        // Database connection information
        $connectionOptions = array(
            'dbname' => 'test',
            'user' => 'root',
            'password' => '1fish2fishredfishbluefish',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
            'CHARSET' => 'UTF8',
            'driverOptions' => array(
                'CHARSET' => 'UTF8'
            )
        );

        self::$em = EntityManager::create( $connectionOptions, $config );
    }

    /**
     *
     * @return EntityManager
     */
    public function getManager()
    {
        return self::$em;
    }

    public function console()
    {
        $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
            'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper( self::$em->getConnection() ),
            'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper( self::$em )
        ));
        
        \Doctrine\ORM\Tools\Console\ConsoleRunner::run( $helperSet );
    }
}