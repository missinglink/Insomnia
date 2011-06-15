<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Insomnia\Registry;

/**
 * Webservice discovery
 * 
 * @webservice:Resource
 * 
 */
class StatusController extends Action
{
    /**
     * Ping
     * 
     * Get information about your request
     * 
     * @webservice:Route("/ping.*", name="ping")
     * @webservice:Method("GET PUT POST DELETE TRACE STATUS")
     *
     */
    public function ping()
    {
        $request = Registry::get( 'request' );
        
        foreach( \array_reverse( \debug_backtrace( false ) ) as $k => $trace )
            $backtrace[] = ($k+1) . '. ' . $trace[ 'class' ] . '::' . $trace[ 'function' ] . '()';
        
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
     * @webservice:Route("/discover", name="discover")
     * @webservice:Method("GET")
     *
     */
    public function endpoints()
    {
        $this->response->merge( array( 'routes' => Registry::get( 'router' )->getClasses() ));
    }
}