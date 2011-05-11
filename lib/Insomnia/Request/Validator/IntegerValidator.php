<?php

namespace Insomnia\Request\Validator;

use \Insomnia\Request,
    \Insomnia\Request\ValidatorException,
    \Insomnia\Request\Validator\RegexValidator;

class IntegerValidator extends RegexValidator
{
    public function __construct( $min = 1, $max = null )
    {
        $chars = ( null !== $max && $min > 1 ) ? '{'.$min.','.$max.'}' : '';
        $this->pattern = '%^(\d+)'.$chars.'$%';
    }
}