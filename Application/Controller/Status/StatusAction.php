<?php

namespace Application\Controller\Status;

use \Application\Controller\StatusController;

class StatusAction extends StatusController
{
    public function action()
    {
        $backtrace = array();
        $cleanPath = realpath( $_SERVER[ 'DOCUMENT_ROOT' ] . '/../' ) . '/';
        foreach( \array_reverse( \debug_backtrace( false ) ) as $k => $trace )
        {
            $backtrace[] = ($k+1) . '. ' . $trace[ 'class' ] . '::' . $trace[ 'function' ] . '()';
        }

        $this->request->getHeader( 'Load' );
        $this->response->merge( array(
            'meta'    => $this->request->getHeaders(),
            'body'    => $this->request->toArray(),
            'debug'=> array(
                'includes' => \count( \get_included_files() ),
                'classes' => \count( \get_declared_classes() ),
                'memory' => floor( \memory_get_peak_usage( ) /1024 ) . 'kb',
                'trace' => $backtrace
            )
        ) );
    }
}