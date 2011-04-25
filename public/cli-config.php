<?php

require_once 'Doctrine/Common/ClassLoader.php';

 // Setup Autoloader (1)
// Define application environment
define('APPLICATION_ENV', "development");

/*
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
*/

// Autoloader (1)
 $classLoader = new \Doctrine\Common\ClassLoader('Doctrine');
 $classLoader->register();

 $classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__);
 $classLoader->register();
 $classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
 $classLoader->register();

// configuration (2)
 $config = new \Doctrine\ORM\Configuration();

// Proxies (3)
 $config->setProxyDir(__DIR__ . '/Proxies');
 $config->setProxyNamespace('Proxies');

 $config->setAutoGenerateProxyClasses((APPLICATION_ENV == "development"));

// Driver (4)
 $driverImpl = $config->newDefaultAnnotationDriver(array(__DIR__."/Entities"));
 $config->setMetadataDriverImpl($driverImpl);

// Caching Configuration (5)
 if (APPLICATION_ENV == "development") {

     $cache = new \Doctrine\Common\Cache\ArrayCache();

 } else {

     $cache = new \Doctrine\Common\Cache\ApcCache();
 }

 $config->setMetadataCacheImpl($cache);
 $config->setQueryCacheImpl($cache);

 $connectionOptions = array(
    'driver' => 'pdo_mysql',
    'dbname' => 'bugs_db_cb',
    'user' => 'bugs_db_cb',
    'password' => 'kk0457',
    'host' => 'localhost');

 $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

 $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
     'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
     'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
 ));
