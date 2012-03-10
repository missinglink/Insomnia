<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Browser
{
    public $name;
    public $version;
    
    /**
     * @param string $name
     * @param string $version
     * @throws \UnexpectedValueException 
     */
    public function __construct( $name, $version )
    {
        if( !is_string( $name ) || !is_string( $version ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $this->name = $name;
        $this->version = $version;
    }
}
