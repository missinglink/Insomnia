<?php

namespace Application\Module\RedisExample\Bootstrap;

use \Symfony\Component\ClassLoader\UniversalClassLoader;

class Redis
{
    public static $rediska;
    
    const HOST = '127.0.0.1';
    const PORT = '6379';

    public function __construct()
    {
        // Autoloader
        $classLoader = new UniversalClassLoader;
        $classLoader->registerNamespace( 'Entities', dirname( __DIR__ ) );
        $classLoader->registerNamespace( 'Proxies', dirname( __DIR__ ) );
        $classLoader->registerNamespace( 'Pagerfanta', \ROOT . 'lib/pagerfanta/src' );
        $classLoader->register();
        
        // Rediska has it's own autoloader
        require_once \ROOT . 'lib/rediska/library/Rediska.php';
        
        // Configure Rediska
        self::$rediska = new \Rediska( array( 'servers' => array() ) );
        self::$rediska->addServer( self::HOST, self::PORT );
    }
 
    /**
     * @return \Rediska
     */
    public function getManager()
    {
        return self::$rediska;
    }
}