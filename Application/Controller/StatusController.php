<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Insomnia\Registry;

/**
 * Webservice discovery
 * 
 * @insomnia:Resource
 * 
 */
class StatusController extends Action
{
    /**
     * Ping
     * 
     * Get information about your request
     * 
     * @insomnia:Route("/ping.*", name="ping")
     * @insomnia:Method("GET PUT POST DELETE TRACE STATUS")
     *
     */
    public function ping()
    {
        $request = Registry::get( 'request' );
        $backtrace = array();
        
        foreach( \array_reverse( \debug_backtrace( false ) ) as $k => $trace )
        {
            if( isset( $trace[ 'class' ] ) && isset( $trace[ 'function' ] ) )
            {
                $backtrace[] = ($k+1) . '. ' . $trace[ 'class' ] . '::' . $trace[ 'function' ] . '()';
            }
        }
        
        $request->getHeader( 'Force Load Headers' );
        $this->response->merge( array(
            'meta'    => $request->getHeaders(),
            'body'    => $request->toArray(),
            'debug'   => array(
                'includes'  => \count( \get_included_files() ),
                'classes'   => \count( \get_declared_classes() ),
                'memory'    => \floor( \memory_get_peak_usage() /1024 ) . 'kb',
                'trace'     => $backtrace
            )
        ) );
    }
    
    /**
     * Discover
     * 
     * List all possible endpoints
     * 
     * @insomnia:Route("/discover", name="discover")
     * @insomnia:Method("GET")
     *
     */
    public function endpoints()
    {
        $application = new \Application\Bootstrap\Insomnia;
        $this->response->merge( array( 'routes' => $application->getRouter()->getClasses() ));
    }
}