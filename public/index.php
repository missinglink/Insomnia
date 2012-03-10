<?php

namespace Insomnia;

use \Community\Module\Testing\Transport\Debugger\Har;
use \Community\Module\Testing\Transport\Debugger\HarDirectoryGlobber;

require_once 'autoloader.php';

// Run Bootstraps
new \Application\Bootstrap\Insomnia;

$errorHandler = new \Community\Module\ErrorHandler\Bootstrap;
$errorHandler->run( Kernel::getInstance() );

$httpHandler = new \Community\Module\HTTP\Bootstrap;
$httpHandler->run( Kernel::getInstance() );

$mimeHandler = new \Community\Module\Mime\Bootstrap;
$mimeHandler->run( Kernel::getInstance() );

\Insomnia\Registry::set( 'request', new \Insomnia\Request );
 



//$log = new Har\Log( new Har\Creator( 'PHP', '5.3' ), new Har\Browser( 'test', 'v1' ) );
//$har = new Har\File( $log );
//
//$page = new Har\Page( 'Test Page', new Har\PageTimings( 1, 1 ) );
//
//$request = new Har\Request( 'GET', 'http://www.google.com', 'HTTP/1.1' );
//
//$response = new Har\Response( 200, 'OK', 'HTTP/1.1' );
//$response->addHeader( new Har\Header( 'Content-Type', 'application/json' ) );
//$response->setContent( new Har\Content( 'application/json', json_encode( array( 'testing' => true ) ) ) );
//
//$request->addHeader( new Har\Header( 'Accept', 'application/json' ) );
//$request->addParam( new Har\Param( 'foo', 'bar' ) );
//
//$entry = new Har\Entry( $page, 999, $request, $response, new Har\Cache, new Har\Timings( 999 ) );
//
//$log->addPage( $page );
//$log->addEntry( $entry );
//
//header( 'Content-Type: application/json' );
////echo 'onInputData(';
//echo json_encode( $har );
////echo ');';
//die;

if( isset( $_GET[ 'har' ] ) )
{
    $globber = new HarDirectoryGlobber;
    $har = $globber->glob( '/tmp/har/*', '*.json' );

    header( 'Content-Type: application/json' );
    echo 'onInputData(';
    echo json_encode( $har );
    echo ');';
    die;
}


Kernel::getInstance()
    
    // Core modules - Warning: Removing these may make your system unstable or unusable
//    ->addModule( new \Community\Module\ErrorHandler\Bootstrap )
//    ->addModule( new \Community\Module\HTTP\Bootstrap )
//    ->addModule( new \Community\Module\Mime\Bootstrap )
        
    // Community modules
    ->addModule( new \Community\Module\Console\Bootstrap )
    ->addModule( new \Community\Module\RequestValidator\Bootstrap )
    ->addModule( new \Community\Module\RestClient\Bootstrap )
    ->addModule( new \Community\Module\Compatibility\Bootstrap )
    ->addModule( new \Community\Module\Cors\Bootstrap )
    ->addModule( new \Community\Module\Session\Bootstrap )
    ->addModule( new \Community\Module\Documentation\Bootstrap )
        
    // User modules
    ->addModule( new \Application\Module\Examples\Bootstrap )
    ->addModule( new \Application\Module\CrudExample\Bootstrap )
    ->addModule( new \Application\Module\HtmlEntities\Bootstrap )
    ->addModule( new \Application\Module\Welcome\Bootstrap )
        
    // Run application
    ->run();