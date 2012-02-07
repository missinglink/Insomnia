<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Subscriber;

use \Insomnia\Kernel\Module\ErrorHandler\Mapper;
use \Insomnia\Pattern\ErrorSubscriber;
use \Insomnia\Response\Code;

/**
 * ExceptionClass Subscriber
 *
 * Assigns a generic mapper based on exception class.
 */
class ExceptionClass extends ErrorSubscriber
{
    private $classMaps = array();

    public function update( \Exception $exception, Response $response )
    {
        if( isset( $this->classMaps[ get_class( $exception ) ] ) )
        {
            return $this->classMaps[ get_class( $exception ) ];
        }

        return false;
    }

    public function addClassMap( $httpCode, $className )
    {
        return $this->classMaps[ $className ] = $httpCode;
    }

    public function getClassMaps()
    {
        return $this->classMaps;
    }

    public function setClassMaps( $classMap )
    {
        $this->classMaps = $classMap;
    }
}