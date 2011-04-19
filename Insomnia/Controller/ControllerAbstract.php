<?php

namespace Insomnia\Controller;

class ControllerAbstract
{
    public function initView( $view = '\Insomnia\View' )
    {
        if( !\class_exists( $view ) )
            throw new ViewException( 'View File Not Found' );
        else $this->view = new $view;

        if( !isset( \Insomnia\Application::$config['path']['view'] ) || !\is_dir( \Insomnia\Application::$config['path']['view'] ) )
            throw new ViewException( 'View Directory Not Found' );
        else $this->view->setViewPath( \Insomnia\Application::$config['path']['view'] );
    }
    
    public function startUp(){}
    public function shutDown(){}
}

class ViewException extends \Exception {};