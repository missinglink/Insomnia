<?php

namespace Insomnia\Response\Format;

use \Insomnia\ArrayAccess,
    \Insomnia\Response\ResponseInterface,
    \Insomnia\Response,
    \Insomnia\Registry;

class ViewRenderer extends ArrayAccess implements ResponseInterface
{
    private $layout     = 'layout',
            $view       = 'index',
            $extension  = '.php',
            $viewContent,
            $stylesheets = array(),
            $scripts = array();

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
        $layoutFile = Registry::get( 'layout_path' ) . $this->layout . $this->extension;

        if( !\file_exists( $layoutFile ) )
            throw new ViewException( 'Layout File Not Found: ' . $this->layout );

        $viewFile = Registry::get( 'view_path' ) . $this->view . $this->extension;

        if( !\file_exists( $viewFile ) )
            throw new ViewException( 'View File Not Found: ' . $this->view );
        
        $this->merge( $response );
        
        \ob_start();
        include( $viewFile );
        $this->viewContent = \ob_get_clean();

        \ob_start();
        include( $layoutFile );
        \ob_end_flush();
    }

    public function content()
    {
        return $this->viewContent;
    }

    public function css( $sheet = null )
    {
        if( is_string( $sheet ) )
            $this->stylesheets[ $sheet ] = $sheet;

        else foreach( $this->stylesheets as $sheet )
            echo '<link rel="stylesheet" href="'.$sheet.'" type="text/css" />' . PHP_EOL;
    }

    public function javascript( $script = null )
    {
        if( is_string( $script ) )
            $this->scripts[ $script ] = $script;
        
        else foreach( $this->scripts as $script )
            echo '<script src="'.$script.'" type="text/javascript"></script>' . PHP_EOL;
    }
}

class ViewException extends \Exception {}