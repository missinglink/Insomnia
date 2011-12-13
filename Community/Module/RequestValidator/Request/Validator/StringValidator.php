<?php

namespace Community\Module\RequestValidator\Request\Validator;

use \Insomnia\Request,
    \Community\Module\RequestValidator\Request\ValidatorException;

class StringValidator
{
    private $min, $max;
    
    public function __construct( $min = 1, $max = null )
    {
        $this->min = $min;
        $this->max = $max;
    }
    
    public function validate( $string, $key )
    {
        // check it's actually a string
        if ( !is_string( $string ) )
        {
            throw new ValidatorException( 'string' );
        }
        
        // check it meets the minimum length requirements
        if ( strlen( $string ) < $this->min )
        {
            throw new ValidatorException( 'string' );
        }
        
        // check it meets the maximum length requirements
        if (is_numeric( $this->max ) && strlen( $string ) > $this->max )
        {
            throw new ValidatorException( 'string' );
        }
    }
}