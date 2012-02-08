<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Validator\ErrorStack;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * 400 handler that shows errors from an ErrorStack object
 */
class ErrorStack400 extends Generic400 implements Mapper
{
    private $exception;

    public function __construct( \Exception $e )
    {
        $this->setException( $e );
    }

    public function map( Response $response )
    {
        parent::map( $response );
        
        if( $this->exception instanceof ErrorStack )
        {
            $response[ 'errors' ] = $this->exception->getErrors();
        }
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setException( $exception )
    {
        $this->exception = $exception;
    }
}