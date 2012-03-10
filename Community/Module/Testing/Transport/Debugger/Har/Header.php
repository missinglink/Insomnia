<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Header
{
    public $name;
    public $value;

    /**
     * @param string $name
     * @param string $value 
     * @throws \UnexpectedValueException 
     */
    public function __construct( $name, $value )
    {
        if( !is_string( $name ) || !is_string( $value ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $this->name = $name;
        $this->value = $value;
    }
    
    /**
     * @return integer 
     */
    public function getSize()
    {
        return mb_strlen( $this->name ) + mb_strlen( $this->value );
    }
}
