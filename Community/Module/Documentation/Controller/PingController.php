<?php

namespace Community\Module\Documentation\Controller;

use \Insomnia\Controller\Action,
    \Insomnia\Registry;

/**
 * Webservice discovery
 * 
 * @insomnia:Resource
 * 
 */
class PingController extends Action
{
    /**
     * Ping
     * 
     * Get information about your request
     * 
     * @insomnia:Route("/ping.*", name="ping")
     * @insomnia:Method("GET PUT POST DELETE")
     * 
     * @insomnia:View( "\Community\Module\Documentation\View\Ping" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     * @insomnia:Documentation( title="Ping", description="A request echo function, useful for testing that a client configuration is working as expected.", category="Documentation" )
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
//            'debug'   => array(
//                'includes'  => \count( \get_included_files() ),
//                'classes'   => \count( \get_declared_classes() ),
//                'memory'    => \floor( \memory_get_peak_usage() /1024 ) . 'kb',
//                'trace'     => $backtrace
//            )
        ) );
    }
}