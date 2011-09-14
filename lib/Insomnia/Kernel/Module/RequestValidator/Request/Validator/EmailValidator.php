<?php

namespace Insomnia\Kernel\Module\RequestValidator\Request\Validator;

use \Insomnia\Request,
    \Insomnia\Kernel\Module\RequestValidator\Request\ValidatorException;

class EmailValidator
{    
    public function validate( $string, $key )
    {
        if( !\filter_var( $string, \FILTER_VALIDATE_EMAIL ) )
            throw new ValidatorException( 'email' );
    }
}