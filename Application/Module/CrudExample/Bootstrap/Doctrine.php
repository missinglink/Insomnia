<?php

namespace Application\Module\CrudExample\Bootstrap;

require_once \ROOT.'/lib/doctrine-orm/lib/Doctrine/ORM/EntityManager.php';

use \Symfony\Component\ClassLoader\UniversalClassLoader;
use \Doctrine\Common\Annotations;

use \Doctrine\ORM\Mapping\Driver\DriverChain,
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
    const DRIVER    = 'pdo_mysql';

    public function __construct()
    {
        // Autoloader
        $classLoader = new UniversalClassLoader;
        $classLoader->registerNamespace( 'Entities', dirname( __DIR__ ) );
        $classLoader->registerNamespace( 'Proxies', dirname( __DIR__ ) );
        $classLoader->registerNamespace( 'Doctrine\\ORM', \ROOT . 'lib/doctrine-orm/lib' );
        $classLoader->registerNamespace( 'Doctrine\\DBAL', \ROOT . 'lib/doctrine-dbal/lib' );
        $classLoader->registerNamespace( 'Pagerfanta', \ROOT . 'lib/pagerfanta/src' );
        $classLoader->register();
        
        $conn = \Doctrine\DBAL\DriverManager::getConnection( $this->getConnectionOptions(), $this->getConfig(), $this->createEventManager() );
        parent::__construct( $conn, $this->getConfig(), $conn->getEventManager() );
        
        self::$em = self::create( $this->getConnectionOptions(), $this->getConfig(), $this->createEventManager() );
    }
    
    private function getConnectionOptions()
    {
        return array(
            'dbname'        => self::DATABASE,
            'user'          => self::USER,
            'password'      => self::PASS,
            'host'          => self::HOST,
            'driver'        => self::DRIVER,
            'CHARSET'       => self::CHARSET,
            'driverOptions' => array( 'CHARSET'=> self::CHARSET )
        );
    }
    
    private function getConfig()
    {
        $config = new Configuration;

        // Proxies
        $config->setProxyDir( dirname( __DIR__ ) . '/Proxies' );
        $config->setProxyNamespace( 'Proxies' );
        $config->setAutoGenerateProxyClasses( APPLICATION_ENV === 'development' );

        // Caching
        $cache = ( \APPLICATION_ENV !== 'development' && extension_loaded( 'apc' ) )
            ? new \Doctrine\Common\Cache\ApcCache
            : new \Doctrine\Common\Cache\ArrayCache;

        $config->setMetadataCacheImpl( $cache );
        $config->setQueryCacheImpl( $cache );
        $config->setResultCacheImpl( $cache );
        
        // Annotations
        $reader = new Annotations\IndexedReader( new Annotations\CachedReader( new Annotations\AnnotationReader, $cache ) );
        
        Annotations\AnnotationRegistry::registerAutoloadNamespace( 'Insomnia\Annotation', \ROOT . 'lib' );
        Annotations\AnnotationRegistry::registerAutoloadNamespace( 'Doctrine\ORM', \ROOT . 'lib/doctrine-orm/lib' );
        
        $reader = new \Doctrine\Common\Annotations\IndexedReader( new Annotations\AnnotationReader );
        
        $annotationDriver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver( $reader, array( dirname( __DIR__ ) . '/Entities' ) );
        
        $config->setMetadataDriverImpl( $annotationDriver );
        
        return $config;
    }
    
    private function createEventManager()
    {
        // Add EventSubscribers here...
        $evm = new \Doctrine\Common\EventManager();
        
        return $evm;
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