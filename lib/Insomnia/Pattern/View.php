<?php

namespace Insomnia\Pattern;

use \Insomnia\Kernel\Module\Mime\Response\Renderer\ViewException;
use \Insomnia\Pattern\ArrayAccess,
    \Insomnia\Response\ResponseInterface;

use \Insomnia\Response;

abstract class View extends ArrayAccess implements ResponseInterface
{
    protected $path,
              $stylesheets  = array(),
              $scripts      = array(),
              $response     = null;
    
    public function render()
    {
        if( !file_exists( $this->getPath() ) || !is_readable( $this->getPath() ) )
        {
            throw new ViewException( 'Failed to load view file: ' . $this->getPath() );
        }
        
        $this->merge( $this->getResponse() );
        
        \ob_start();
        require $this->getPath();
        \ob_get_flush();
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function setPath( $path )
    {        
        $this->path = $path;
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
    
    /** @return \Insomnia\Response  */
    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse( Response $response )
    {
        $this->response = $response;
    }
}