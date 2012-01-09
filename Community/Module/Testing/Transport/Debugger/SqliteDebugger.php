<?php

namespace Community\Module\Testing\Transport\Debugger;

use \Insomnia\Pattern\Observer,
    \Community\Module\Console\Response\Colourize,
    \Community\Module\Testing\Transport\Transporter;

use \Doctrine\ORM\EntityManager,
    \Doctrine\ORM\Configuration;

class SqliteDebugger extends Observer
{
    const PARSE_RESPONSE = false;
    
    public function __construct()
    {
        if( !extension_loaded( 'sqlite' ) )
        {
            throw new \Exception( 'PHP sqlite extension is required but not currently installed' );
        }
        
        //configuration
        $config = new Configuration();
        $config->setProxyDir( __DIR__ . '/Sqlite/Proxies' );
        $config->setProxyNamespace( 'Proxies' );
        $config->setAutoGenerateProxyClasses( APPLICATION_ENV === 'development' );
        $config->setAutoGenerateProxyClasses(true);

        $cache = new \Doctrine\Common\Cache\ArrayCache;

        $config->setMetadataCacheImpl( $cache );
        $config->setQueryCacheImpl( $cache );
        $config->setResultCacheImpl( $cache );

        $reader = new \Doctrine\Common\Annotations\AnnotationReader( $cache, new \Doctrine\Common\Annotations\Parser );
        $reader->setDefaultAnnotationNamespace('Doctrine\ORM\Mapping\\');
        
        $annotationDriver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver( $reader, array( __DIR__ . '/Sqlite/Entity' ) );
        $config->setMetadataDriverImpl( $annotationDriver );
        
        $em = EntityManager::create(
            array(
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/Sqlite/database.sqlite'
            ),
            $config
        );
        
        $greeting = new Sqlite\Entity\Request( 'Hello World!' );
        
        $em->persist($greeting);
 
        //Flushing all changes to database
        $em->flush();
    }

    /* @var $transaction Transporter */
    public function update( \SplSubject $transport )
    {
//        if( php_sapi_name() == 'cli' && empty( $_SERVER['REMOTE_ADDR'] ) )
//        {
            $this->debugRequest( $transport );
            $this->debugResponse( $transport );
//        }
    }
    
    private function debugRequest( Transporter $transport )
    {
//        echo \PHP_EOL;
//        $methodString   = ' ' . $this->output( $transport->getRequest()->getMethod(), 'brown' ) . ' ';
//        $protocolString = ' ' . $this->output( $transport->getRequest()->getProtocol(), 'dark_gray' );
//
//        echo $methodString . $transport->getRequest()->getUri() . ( self::DEBUG_SIMPLE === $this->getDebugLevel() ? $this->output( ' -', 'brown' ) : $protocolString . \PHP_EOL );
//
//        if( self::DEBUG_SIMPLE < $this->getDebugLevel() )
//        {
//            foreach( $transport->getRequest()->getHeaders() as $headerKey => $headerValue )
//            {
//                $headerString = '  ' . $this->output( $headerKey . ': ', 'light_blue' );
//                echo $this->output( $headerString . $headerValue ) . \PHP_EOL;
//            }
//            
//            echo \PHP_EOL;
//        }
    }
    
    private function debugResponse( Transporter $transport )
    {
//        $protocolString     = ' ' . $this->output( $transport->getResponse()->getProtocol(), 'dark_gray' );
//        $responseCodeString = ' ' . $this->output( $transport->getResponse()->getCode(), 'brown' );
//        $responseTimeString = ' ' . $this->output( '(' . round( $transport->getResponse()->getExecutionTime() ) . 'ms)', 'light_blue' );
//
//        echo $this->output( ( self::DEBUG_SIMPLE < $this->getDebugLevel() ? $protocolString : '' ) . $responseCodeString . $responseTimeString ) . \PHP_EOL;
//
//        if( self::DEBUG_SIMPLE < $this->getDebugLevel() )
//        {            
//            foreach( $transport->getResponse()->getHeaders() as $headerKey => $headerValue )
//            {
//                $headerString = '  ' . $this->output( $headerKey . ': ', 'light_blue' );
//                echo $this->output( $headerString . $headerValue ) . \PHP_EOL;
//            }
//        }
//
//        if( self::DEBUG_VERBOSE === $this->getDebugLevel() )
//        {
//            echo \PHP_EOL;
//            echo $this->output( ' Response:', 'brown' ) . \PHP_EOL;
//            echo $this->output( str_pad( $transport->getResponse()->getBody(), 120, ' ' ) ) . \PHP_EOL;
//
//            if( true === self::PARSE_RESPONSE )
//            {
//                switch( $transport->getResponse()->getHeader( 'Content-Type' ) )
//                {
//                    case 'application/json' :
//                        $json = json_decode( $transport->getResponse()->getBody(), true );
//                        echo $this->output( str_pad( \PHP_EOL . print_r( $json, true ) . \PHP_EOL, 120, ' ' ) ) . \PHP_EOL;
//                        break;
//                }
//            }
//        }
    }
}
