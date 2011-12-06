<?php

namespace Community\Module\RequestValidator\Dispatcher\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Annotation\Parser\ParamParser;

use \Community\Module\RequestValidator\Request\Validator\IntegerValidator,
    \Community\Module\RequestValidator\Request\Validator\StringValidator,
    \Community\Module\RequestValidator\Request\Validator\RegexValidator,
    \Community\Module\RequestValidator\Request\Validator\ArrayValidator,
    \Community\Module\RequestValidator\Request\Validator\EmailValidator;
    

class ParamAnnotationValidator extends Observer
{
    /* @var $request \Insomnia\EndPoint */
    public function update( \SplSubject $endpoint )
    {
        //-- Parameter Validation
        $params = new ParamParser( $endpoint->getMethodAnnotations() );

        foreach( $params as $param )
        {            
            switch( $param[ 'type' ] )
            {
                case 'integer' : $validator = new IntegerValidator( 1, 10 ); break;
                case 'string' : $validator = new StringValidator( 1, 10 ); break;
                case 'regex' : $validator = new RegexValidator( $param[ 'regex' ] ); break;
                case 'array[string]' : $validator = new ArrayValidator( 'string' ); break;
                case 'array[numeric]' : $validator = new ArrayValidator( 'numeric' ); break;
                case 'email' : $validator = new EmailValidator; break;
            }

            if( !isset( $validator ) ) throw new \Exception( 'Unsupported Request Type "' . $param[ 'type' ] . '"' );

            if( isset( $param[ 'optional' ] ) )
                $endpoint->getController()->getValidator()->optional( $param[ 'name' ], $validator );
            else
                $endpoint->getController()->getValidator()->required( $param[ 'name' ], $validator );
            
            $endpoint->getController()->getValidator()->validate();
        }        
    }
}