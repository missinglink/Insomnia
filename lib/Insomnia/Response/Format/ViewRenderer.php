<?php

namespace Insomnia\Response\Format;

use \Insomnia\ArrayAccess,
    \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

class ViewRenderer extends ArrayAccess implements ResponseInterface
{
    private $layoutPath,
            $viewPath,
            $layout     = 'index',
            $view       = 'index',
            $extension  = '.php';

    public function setLayoutPath( $path )
    {
        $this->layoutPath = realpath( $path ) . \DIRECTORY_SEPARATOR;
    }

    public function setViewPath( $path )
    {
        $this->viewPath = realpath( $path ) . \DIRECTORY_SEPARATOR;
    }

    public function useLayout( $layout )
    {
        $this->layout = $layout;
    }

    public function useView( $view )
    {
        $this->view = $view;
    }

    public function render( Response $response )
    {
        $layoutFile = $this->layoutPath . $this->layout . $this->extension;

        if( !\file_exists( $layoutFile ) )
            throw new ViewException( 'Layout File Not Found: ' . $this->layout . $this->extension );

        $viewFile = $this->viewPath . $this->view . $this->extension;

        if( !\file_exists( $viewFile ) )
            throw new ViewException( 'View File Not Found: ' . $this->view . $this->extension );

        $this->merge( $response );
        header( 'Content-Type: text/html' );
        \ob_start();
        include( $layoutFile );
        \ob_end_flush();
    }

    public function content()
    {
        $viewFile = $this->viewPath . $this->view . $this->extension;

        \ob_start();
        include( $viewFile );
        \ob_end_flush();
    }
}

class ViewException extends \Exception {}