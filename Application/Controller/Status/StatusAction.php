<?php

namespace Application\Controller\Status;

use \Insomnia\Controller\Action,
    \Insomnia\Registry;

class StatusAction extends Action
{
    public function action()
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
}