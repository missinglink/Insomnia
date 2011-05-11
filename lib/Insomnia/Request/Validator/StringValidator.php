<?php

namespace Insomnia\Request\Validator;

use \Insomnia\Request,
    \Insomnia\Request\ValidatorException;

class StringValidator
{
    private $pattern;

    public function __construct( $min = 1, $max = null )
    {
        $chars = ( null !== $max && $min > 1 ) ? '{'.$min.','.$max.'}' : '';
        $this->pattern = '^(.+)'.$chars.'$';
    }
    
    public function validate( $string, $key )
    {
        $validator = new RegexValidator( $this->pattern );
        $validator->validate( $string, $key );
    }
}