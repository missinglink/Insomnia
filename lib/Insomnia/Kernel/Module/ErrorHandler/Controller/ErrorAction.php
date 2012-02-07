<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Controller;

use \Application\Controller\ErrorsController,
    \Insomnia\Kernel\Module\ErrorHandler\Mapper,
    \Insomnia\Response\Code,
    \Insomnia\Registry;

use \Insomnia\Kernel;

/**
 * Error Controller
 * 
 * @insomnia:Resource
 * 
 */
class ErrorAction extends \Insomnia\Controller\Action
{   
    /**
     * Map Errors to Output
     * 
     * @insomnia:View( "Insomnia\Kernel\Module\ErrorHandler\View\Error" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     * @param \Exception $exception 
     */
    public function action( \Exception $exception )
    {
        foreach( Kernel::getInstance()->getErrorSubscribers() as $subscriber )
        {
            $subscriber->update( $exception, $request );
        }

        $mappers = array();
        
        switch( $code = $exception->getCode() )
        {
            case 400 :
                $mappers[ $code ] = new Mapper\ErrorStack400( $exception );
                //$mappers[ $code ][] = new Mapper\Generic400;
                break;

            case 401 : $mappers[ $code ] = new Mapper\Generic401; break;
            case 402 : $mappers[ $code ] = new Mapper\Generic402; break;
            case 403 : $mappers[ $code ] = new Mapper\Generic403; break;
            case 404 : $mappers[ $code ] = new Mapper\Generic404; break;
            case 405 : $mappers[ $code ] = new Mapper\Generic405; break;
            case 406 : $mappers[ $code ] = new Mapper\Generic406; break;
            case 407 : $mappers[ $code ] = new Mapper\Generic407; break;
            case 408 : $mappers[ $code ] = new Mapper\Generic408; break;
            case 409 : $mappers[ $code ] = new Mapper\Generic409; break;
            case 410 : $mappers[ $code ] = new Mapper\Generic410; break;
            case 411 : $mappers[ $code ] = new Mapper\Generic411; break;
            case 412 : $mappers[ $code ] = new Mapper\Generic412; break;
            case 413 : $mappers[ $code ] = new Mapper\Generic413; break;
            case 414 : $mappers[ $code ] = new Mapper\Generic414; break;
            case 415 : $mappers[ $code ] = new Mapper\Generic415; break;
            case 416 : $mappers[ $code ] = new Mapper\Generic416; break;
            case 417 : $mappers[ $code ] = new Mapper\Generic417; break;
            case 500 : $mappers[ $code ] = new Mapper\Generic500; break;
        }

        // Find a mapper for current exception code
        $mapper = isset( $mappers[ $exception->getCode() ] )
                    ? $mappers[ $exception->getCode() ]
                    : false;

        if( !$mapper instanceof \Insomnia\Pattern\Mapper )
        {
            $mapper = isset( $mappers[ 500 ] )
                ? $mappers[ 500 ]
                : new Mapper\Generic500;
        }

        $response = $this->getResponse();
        $mapper->map( $response );

        $subscriber = new Mapper\Backtrace( $exception );
        $subscriber->map( $response );
    }
}