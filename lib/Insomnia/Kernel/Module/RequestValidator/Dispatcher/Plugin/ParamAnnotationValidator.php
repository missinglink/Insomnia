<?php

namespace Insomnia\Kernel\Module\RequestValidator\Dispatcher\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Annotation\Parser\ParamParser;

use \Insomnia\Kernel\Module\RequestValidator\Request\Validator\IntegerValidator,
    \Insomnia\Kernel\Module\RequestValidator\Request\Validator\StringValidator;

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