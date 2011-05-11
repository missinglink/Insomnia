<?php

namespace Application\Controller\Status;

use \Application\Controller\StatusController,
    \Insomnia\Registry;

class StatusAction extends StatusController
{
    public function action()
    {
        $backtrace = array();
        $cleanPath = \realpath( $_SERVER[ 'DOCUMENT_ROOT' ] . '/../' ) . '/';
        foreach( \array_reverse( \debug_backtrace( false ) ) as $k => $trace )
            $backtrace[] = ($k+1) . '. ' . $trace[ 'class' ] . '::' . $trace[ 'function' ] . '()';

        $request = Registry::get( 'request' );
        
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
}