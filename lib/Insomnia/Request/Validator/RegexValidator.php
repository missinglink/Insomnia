<?php

namespace Insomnia\Request\Validator;

use \Insomnia\Request,
    \Insomnia\Request\ValidatorException;

class RegexValidator
{
    protected $pattern;

    public function __construct( $pattern )
    {
        $this->pattern = '%'.$pattern.'%';
    }
    
    public function validate( $string, $key )
    {
        if( !is_string( $string ) || !preg_match( $this->pattern, $string ) )
            throw new ValidatorException( $key . ' (invalid)' );
    }
}