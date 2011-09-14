<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

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
            $scripts        = array(),
            $basePath       = '';

    public function __construct()
    {
        $this->setViewBasePath( \ROOT . Registry::get( 'layout_path' ) . \DIRECTORY_SEPARATOR );
    }
    
    public function useLayout( $layout )
    {
        $this->layout = $layout;
    }

//    public function useView( $view )
//    {
//        $this->view = $view;
//    }

    public function render( Response $response )
    {
        if( !\file_exists( $layoutFile = \ROOT . Registry::get( 'layout_path' ) . \DIRECTORY_SEPARATOR . $this->layout . Registry::get( 'view_extension' ) ) )
            throw new ViewException( 'Layout File Not Found: ' . $this->layout );
        
//        try {
            if( !\file_exists( $viewFile = $this->getViewBasePath() . $response->getView() . Registry::get( 'view_extension' ) ) )
                throw new ViewException( 'View File Not Found: ' . $this->view );
//        }
//        catch( ViewException $e )
//        {
//            if( !\file_exists( $viewFile = $this->getViewBasePath() . 'errors/scaffold' . Registry::get( 'view_extension' ) ) )
//                throw new ViewException( 'Scaffold View File Not Found: ' . $viewFile );
//        }
        
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
    
    public function getViewBasePath()
    {
        return $this->basePath;
    }

    public function setViewBasePath( $basePath )
    {
        $this->basePath = $basePath;
    }
}

class ViewException extends \Exception {}