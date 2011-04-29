<?php

namespace Insomnia\Request\Validator;

use \Insomnia\Request,
    \Insomnia\Request\ValidatorException;

class RegexValidator
{
    private $pattern;

    public function __construct( $pattern )
    {
        $this->pattern = '_'.$pattern.'_';
    }
    
    public function validate( $string, $key )
    {
        if( !preg_match( $this->pattern, $string ) )
            throw new ValidatorException( $key . ' (invalid)' );
    }
}