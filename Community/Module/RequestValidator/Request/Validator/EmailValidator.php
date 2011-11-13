<?php

namespace Community\Module\RequestValidator\Request\Validator;

use \Insomnia\Request,
    \Community\Module\RequestValidator\Request\ValidatorException;

class EmailValidator
{    
    public function validate( $string, $key )
    {
        if( !\filter_var( $string, \FILTER_VALIDATE_EMAIL ) )
            throw new ValidatorException( 'email' );
    }
}