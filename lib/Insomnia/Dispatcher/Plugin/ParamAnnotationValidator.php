<?php

namespace Insomnia\Dispatcher\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Annotation\Parser\ParamParser;

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
                case 'integer' : $validator = new \Insomnia\Request\Validator\IntegerValidator( 1, 10 ); break;
                case 'string' : $validator = new \Insomnia\Request\Validator\StringValidator( 1, 10 ); break;
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