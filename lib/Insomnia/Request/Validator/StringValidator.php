<?php

namespace Insomnia\Request\Validator;

use \Insomnia\Request,
    \Insomnia\Request\ValidatorException,
    \Insomnia\Request\Validator\RegexValidator;

class StringValidator extends RegexValidator
{
    public function __construct( $min = 1, $max = null )
    {
        $chars = ( null !== $max && $min > 1 ) ? '{'.$min.','.$max.'}' : '';
        $this->pattern = '%^(.+)'.$chars.'$%';
    }
}