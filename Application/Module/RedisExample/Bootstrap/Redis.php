<?php

namespace Application\Module\RedisExample\Bootstrap;

use \Doctrine\Common\ClassLoader;

class Redis
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
//        $classLoader->registerNamespace( 'Doctrine\\ORM', \ROOT . 'lib/doctrine-orm/lib' );
//        $classLoader->registerNamespace( 'Doctrine\\DBAL', \ROOT . 'lib/doctrine-dbal/lib' );
        $classLoader->registerNamespace( 'Pagerfanta', \ROOT . 'lib/pagerfanta/src' );
        $classLoader->register();
    }
 
    /**
     *
     * @return EntityManager
     */
    public function getManager()
    {
        return self::$em;
    }
}