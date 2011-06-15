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
    
    const DATABASE  = 'test';
    const HOST      = 'localhost';
    const USER      = 'php';
    const PASS      = '3889y23b4jh2bhjh5vjv2jh3vjhv5j23tg545';
    const CHARSET   = 'UTF8';

    public function __construct()
    {
        // Autoloader (1)
        $classLoader = new ClassLoader( 'Entities', \ROOT . 'Application' );
        $classLoader->register();
        $classLoader = new ClassLoader( 'Proxies', \ROOT . 'Application' );
        $classLoader->register();
        $classLoader = new ClassLoader( 'DoctrineExtensions', \ROOT . 'lib' );
        $classLoader->register();
        $classLoader = new ClassLoader( 'Gedmo', \ROOT . 'lib' );
        $classLoader->register();

        // configuration (2)
        $config = new Configuration;

        // Proxies (3)
        $config->setProxyDir( \ROOT . 'Application/Proxies' );
        $config->setProxyNamespace( 'Proxies' );
        $config->setAutoGenerateProxyClasses( APPLICATION_ENV === 'development' );

        // Driver (4)
        $config->setMetadataDriverImpl( $config->newDefaultAnnotationDriver( array( \ROOT . 'Application/Entities' ) ) );

        // Caching Configuration (5)
        $cache = ( APPLICATION_ENV === 'development' )
            ? new \Doctrine\Common\Cache\ArrayCache
            : new \Doctrine\Common\Cache\ApcCache;

        $config->setMetadataCacheImpl( $cache );
        $config->setQueryCacheImpl( $cache );

        // Database connection information
        $connectionOptions = array(
            'dbname'        => self::DATABASE,
            'user'          => self::USER,
            'password'      => self::PASS,
            'host'          => self::HOST,
            'driver'        => 'pdo_mysql',
            'CHARSET'       => self::CHARSET,
            'driverOptions' => array( 'CHARSET'=> self::CHARSET )
        );
        
        // Timestampable extension
        $evm = new \Doctrine\Common\EventManager();
        $evm->addEventSubscriber( new \Gedmo\Timestampable\TimestampableListener );

        self::$em = EntityManager::create( $connectionOptions, $config, $evm );
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