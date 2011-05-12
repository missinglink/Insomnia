<?php

namespace Insomnia\Response\Format;

use \Insomnia\ArrayAccess,
    \Insomnia\Response\ResponseInterface,
    \Insomnia\Response,
    \Insomnia\Registry;

class ViewRenderer extends ArrayAccess implements ResponseInterface
{
    private $layout         = 'layout',
            $view           = 'index',
            $viewContent    = '',
            $stylesheets    = array(),
            $scripts        = array();

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
        if( !\file_exists( $layoutFile = \ROOT.Registry::get( 'layout_path' ).'/'.$this->layout.Registry::get( 'view_extension' ) ) )
            throw new ViewException( 'Layout File Not Found: ' . $this->layout );

        if( !\file_exists( $viewFile = \ROOT.Registry::get( 'view_path' ).'/'.$this->view.Registry::get( 'view_extension' ) ) )
            throw new ViewException( 'View File Not Found: ' . $this->view );
        
        $this->merge( $response );
        
        \ob_start();
        require $viewFile;
        $this->viewContent = \ob_get_clean();

        \ob_start();
        require $layoutFile;
        \ob_end_flush();
    }

    public function content()
    {
        return $this->viewContent;
    }

    public function css( $sheet = null )
    {
        if( \is_string( $sheet ) )
            $this->stylesheets[ $sheet ] = $sheet;

        else foreach( $this->stylesheets as $sheet )
            echo '<link rel="stylesheet" href="'.$sheet.'" type="text/css" />' . PHP_EOL;
    }

    public function javascript( $script = null )
    {
        if( \is_string( $script ) )
            $this->scripts[ $script ] = $script;
        
        else foreach( $this->scripts as $script )
            echo '<script src="'.$script.'" type="text/javascript"></script>' . PHP_EOL;
    }
}

class ViewException extends \Exception {}