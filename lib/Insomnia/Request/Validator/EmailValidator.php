<?php

namespace Insomnia\Request\Validator;

use \Insomnia\Request,
    \Insomnia\Request\ValidatorException;

class EmailValidator
{    
    public function validate( $string, $key )
    {
        if( !\filter_var( $string, \FILTER_VALIDATE_EMAIL ) )
            throw new ValidatorException( 'email' );
    }
}