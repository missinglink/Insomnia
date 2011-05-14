<?php

namespace Insomnia\Request;

use \Insomnia\Registry;

class ValidatorException extends \Exception {}

class RequestValidator
{
    private $params = array();

    public function required( $key, $validator )
    {
        if( !Registry::get( 'request' )->hasParam( $key ) )
            throw new ValidatorException( $key . ' (required)' );
        
        $this->optional( $key, $validator );
        
    }

    public function optional( $key, $validator )
    {
        $request = Registry::get( 'request' );
        
        if( $request->hasParam( $key ) )
        {
            $validator->validate( $request->getParam( $key ), $key );
            $this->params[ $key ] = $request->getParam( $key );
        }
    }
    
    public function getParams()
    {
        return $this->params;
    }

    public function getParam( $key )
    {
        return isset( $this->params[ $key ] ) ? $this->params[ $key ] : null;
    }
}