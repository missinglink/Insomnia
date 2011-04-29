<?php

namespace Insomnia\Request;

use \Insomnia\Request;

class ValidatorException extends \Exception {}

class RequestValidator
{
    private $request;

    public function __construct( Request $request )
    {
        $this->request = $request;
    }

    public function required( $key, $validator )
    {
        if( !isset( $this->request[ $key ] ) )
            throw new ValidatorException( $key . ' (required)' );
        
        $validator->validate( $this->request[ $key ], $key );
    }

    public function optional( $key, $validator )
    {
        if( isset( $this->request[ $key ] ) )
            $validator->validate( $this->request[ $key ], $key );
    }
}