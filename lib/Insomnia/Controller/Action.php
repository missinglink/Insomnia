<?php

namespace Insomnia\Controller;

use \Insomnia\Response;
use \Insomnia\Request\RequestValidator;
use \Insomnia\Registry;

abstract class Action
{
    /* @var $response \Insomnia\Response */
    protected $response;

    /* @var $validator \Insomnia\Request\RequestValidator */
    protected $validator;

    public function __construct()
    {
        $validator = new RequestValidator;       
        $this->setValidator( $validator );
        
        $this->setResponse( new Response );
        $this->validate();
    }
    
    public function validate()
    {
        $reader = new \Insomnia\Router\AnnotationReader( \get_class( $this ) );
        $params = new \Insomnia\Annotation\Parser\ParamParser(
                $reader->getMethodAnnotations(
                        Registry::get( 'dispatcher' )->getRoute()->getReflectionMethod()
                )
        );
        
        foreach( $params as $param )
        {
            switch( $param[ 'type' ] )
            {
                case 'integer' : $validator = new \Insomnia\Request\Validator\IntegerValidator( 1, 10 ); break;
                case 'string' : $validator = new \Insomnia\Request\Validator\StringValidator( 1, 10 ); break;
            }
            
            if( !isset( $validator ) ) throw new Exception( 'Unsupported Request Type "' . $param[ 'type' ] . '"' );

            if( isset( $param[ 'optional' ] ) )
                $this->validator->optional( $param[ 'name' ], $validator );
            else
                $this->validator->required( $param[ 'name' ], $validator );
        }
        
        $this->validator->validate();
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse( $response )
    {
        $this->response = $response;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator( $validator )
    {
        $this->validator = $validator;
    }
}