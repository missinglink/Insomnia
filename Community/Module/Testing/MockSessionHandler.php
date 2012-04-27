<?php

namespace Community\Module\Testing;

class MockSessionHandler
{
    private $sessions;
    private $log;

    public function open( $savePath, $sessionName )
    {
        $this->writeLog( 'open' );
        
        return true;
    }

    public function close()
    {
        $this->writeLog( 'close' );
        
        return true;
    }

    public function read( $id )
    {
        $this->writeLog( 'read' );
        
        return isset( $this->sessions[ "sess_$id" ] ) ? (string) $this->sessions[ "sess_$id" ] : null;
    }

    public function write( $id, $data )
    {
        $this->writeLog( 'write' );
        
        $this->sessions[ "sess_$id" ] = $data;
        
        return true;
    }

    public function destroy( $id )
    {
        $this->writeLog( 'destroy' );
        
        unset( $this->sessions[ "sess_$id" ] );
        
        return true;
    }

    public function gc( $maxlifetime )
    {
        $this->writeLog( 'gc' );
        
        return true;
    }
    
    public function getSessions()
    {
        return $this->sessions;
    }

    public function setSessions( $sessions )
    {
        $this->sessions = $sessions;
    }
    
    public function writeLog( $metric, $diff = +1 )
    {
        if( !isset( $this->log[ $metric ] ) )
        {
            $this->log[ $metric ] = 0;
        }
        
        $this->log[ $metric ] += $diff;
    }
    
    public function getLogFor( $metric )
    {
        return isset( $this->log[ $metric ] ) ? (int) $this->log[ $metric ] : 0;
    }
    
    public function getLog()
    {
        return $this->log;
    }
}