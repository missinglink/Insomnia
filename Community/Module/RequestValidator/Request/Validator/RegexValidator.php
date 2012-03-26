<?php

namespace Community\Module\RequestValidator\Request\Validator;

use \Insomnia\Request,
    \Community\Module\RequestValidator\Request\ValidatorException;

class RegexValidator
{
    protected $pattern;

    public function __construct( $pattern )
    {
        $this->pattern = '%'.$pattern.'%';
    }
    
    public function validate( $string, $key )
    {
        if( !is_scalar( $string ) || !preg_match( $this->pattern, $string ) )
        {
            throw new ValidatorException( 'regex' );
        }
    }
}