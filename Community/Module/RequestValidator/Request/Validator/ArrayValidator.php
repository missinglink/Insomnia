<?php

namespace Community\Module\RequestValidator\Request\Validator;

use \Insomnia\Request,
    \Community\Module\RequestValidator\Request\ValidatorException;

class ArrayValidator
{    
    // This is set to the expected type for every item in the array
    private $type;

    public function __construct( $type )
    {
        $this->type = $type;
    }

    public function validate( $value, $key )
    {
        // We should now validate each item in the array
        // to make sure that they are known/recognised types
                
        if( !is_array($value) ) throw new ValidatorException( 'array[\'' . $this->type . '\']' );
        
        foreach( $value as $element ) 
        {
            switch( $this->type )
            {
                case 'numeric' : 
                    if( !is_numeric( $element ) ) throw new ValidatorException( 'array[\'' . $this->type . '\']' );
                    break;

                case 'string' : 
                    if( !is_string( $element ) ) throw new ValidatorException( 'array[\'' . $this->type . '\']' );
                    break;
                    
                case 'object' : 
                    if( !is_object( $element ) ) throw new ValidatorException( 'array[\'' . $this->type . '\']' );
                    break;
            }
        }        
    }
}