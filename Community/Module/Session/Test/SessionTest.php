<?php

namespace Community\Module\Session;

use \Community\Module\Testing\MockSessionHandler;
/**
 * This test covers all functionality of the Session class
 */
class SessionTest extends \PHPUnit_Framework_TestCase
{
    private $handler;
    
    public function setUp()    
    {                
        $this->handler = new MockSessionHandler;
        
        session_set_save_handler(
            array( $this->handler, 'open' ),
            array( $this->handler, 'close' ),
            array( $this->handler, 'read' ),
            array( $this->handler, 'write' ),
            array( $this->handler, 'destroy' ),
            array( $this->handler, 'gc' )
        );
        
//        $this->assertEquals( 0, count( $this->handler->getSessions() ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'read' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'write' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'open' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'close' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'destroy' ) ) );
    }
    
    public function testSessionIsNotWrittenUntilCloseIsCalled()
    {       
        $this->assertEquals( 0, count( $this->handler->getSessions() ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'read' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'write' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'open' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'close' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'destroy' ) ) );
        
        $session = new Session( 'aaaa' );
        $session->set( 'pie', 'good' );
        $_SESSION[ 'dog' ] = 'cat';
        
        $this->assertEquals( 0, count( $this->handler->getSessions() ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'read' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'write' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'open' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'close' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'destroy' ) ) );
        
        $session->close();
        
        $this->assertEquals( 1, count( $this->handler->getSessions() ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'read' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'write' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'open' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'close' ) ) );
//        $this->assertEquals( 1, count( $this->handler->getLogFor( 'destroy' ) ) );
        
//        var_dump( $this->handler->getSessions() );
    }
}