<?php

namespace Insomnia;
//use Doctrine\Common\Collections\ArrayCollection;
//  
//use Doctrine\Common\ClassLoader,
//    Doctrine\ORM\Configuration,
//    Doctrine\ORM\EntityManager,
//    Doctrine\Common\Cache\ApcCache,Doctrine\ORM\Events,
//    Entities\DataSource,  Entities\Event, Entities\EventI18N ;

class Doctrine
{
    public static $em;
    
    public function __construct()
    {
        $this->bootstrap();
    }
    
    public function bootstrap()
    {
        $classLoader = new \Doctrine\Common\ClassLoader( 'Doctrine' );
        $classLoader->register();
        
        $classLoader = new \Doctrine\Common\ClassLoader( 'Entities', __DIR__ );
        $classLoader->register();
        
        $config = new \Doctrine\ORM\Configuration;
        
        $chainDriverImpl = new \Doctrine\ORM\Mapping\Driver\DriverChain();
        $driverImpl = $config->newDefaultAnnotationDriver( array( __DIR__ . '/Entities' ) );
        $chainDriverImpl->addDriver( $driverImpl, '/Entities' );
        $config->setMetadataDriverImpl( $chainDriverImpl );
        
        // Proxy configuration
        $config->setProxyDir( __DIR__ . '/Proxies' );
        $config->setProxyNamespace( 'Proxies' );
        $config->setMetadataCacheImpl( new \Doctrine\Common\Cache\ArrayCache );
        
        // Database connection information
        $connectionOptions = array(
            'dbname' => 'test',
            'user' => 'timeout',
            'password' => '65dali32',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
            'CHARSET' => 'UTF8',
            'driverOptions' => array(
                'CHARSET' => 'UTF8'
            ) 
        );

        // Create EntityManager
        self::$em = \Doctrine\ORM\EntityManager::create( $connectionOptions, $config );
    }
}