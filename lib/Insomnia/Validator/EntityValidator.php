<?php

namespace Insomnia\Validator;

use \Insomnia\Request\ValidatorException;

class EntityValidator
{
    private $entity;
    private $stack      = array();
    private $params     = array();
    private $errors     = array();

    public function __construct( $entity )
    {
        $this->entity = $entity;
    }
    
    public function required( $key, $validator )
    {
        $this->stack[ 'r_' . $key ] = $validator;
    }

    public function optional( $key, $validator )
    {
        $this->stack[ 'o_' . $key ] = $validator;
    }
    
    public function validate()
    {
        $entityClass = new \ReflectionClass( $this->entity );
                    
        foreach( $this->stack as $key => $validator )
        {
            $optional = ( \substr( $key, 0, 2 ) === 'o_' );
            $key      = \substr( $key, 2 );
            
            try{
                $property = $entityClass->getProperty( $key );
                $property->setAccessible( true );
                $validator->validate( $property->getValue( $this->entity ), $key );
            }
            
            catch( ValidatorException $e )
            {
                $this->errors[ $key ] = $e->getMessage();
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