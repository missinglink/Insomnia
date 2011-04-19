<?php

namespace Insomnia\Controller;

class ControllerAbstract
{
    public function initView( $view = '\Insomnia\View', $path = false )
    {
        if( !\class_exists( $view ) )
            throw new ViewException( 'View File Not Found' );
        else $this->view = new $view;

        if( false === $path || !\is_dir( $path ) )
            $this->view->setViewPath( __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'View' );
        else $this->view->setViewPath( $path );
    }
}

class ViewException extends \Exception {};