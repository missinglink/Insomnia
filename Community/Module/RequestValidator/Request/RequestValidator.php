<?php

namespace Community\Module\RequestValidator\Request;

use \Insomnia\Registry;

class RequestValidator
{
    private $stack      = array();
    private $params     = array();
    private $errors     = array();

    public function required( $key, $validator )
    {
        $this->stack[ 'r_' . $key ] = $validator;
    }

    public function optional( $key, $validator )
    {
        $this->stack[ 'o_' . $key ] = $validator;
    }
    
    public function getReference()
    {
        $ref = array();
        
        foreach( $this->stack as $key => $validator )
        {
            $optional = ( \substr( $key, 0, 2 ) === 'o_' );
            $key      = \substr( $key, 2 );
            $type     = \get_class( $validator );
            
            $this->errors[ $key ] = array(
                'required' => !$optional,
                'type'     => $type
            );
        }
        
        return $ref;
    }
    
    public function validate()
    {
        /* @var $request \Insomnia\Request */
        $request = Registry::get( 'request' );
        
        foreach( $this->stack as $key => $validator )
        {
            $optional = ( \substr( $key, 0, 2 ) === 'o_' );
            $key      = \substr( $key, 2 );
            
            if( $request->hasParam( $key ) )
            {
                try
                {    
                    $sanitiser = new InputSanitiser( $request->getParam( $key ) );
                    $sanitiser->removeTagBody( 'script' )
                              ->removeTagBody( 'style' )
                              ->stripTags();
                    
                    $validator->validate( $sanitiser->getValue(), $key );
                    $this->params[ $key ] = $sanitiser->getValue();
                }
                catch( ValidatorException $e )
                {
                    $this->errors[ $key ] = $e->getMessage();
                }
            }
            
            else if( !$optional ) {
                $this->errors[ $key ] = 'null';
            }
        }
        
        if ( \count( $this->errors ) > 0 )
        {
            throw new \Insomnia\Validator\ErrorStack( $this->errors );
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
    
    public function getErrors()
    {
        return $this->errors;
    }
}