<?php

namespace Insomnia\Kernel\Module\Mime;

use \Insomnia\Kernel\Module\Mime\Response\Renderer\ViewException;
use \Insomnia\Pattern\ArrayAccess,
    \Insomnia\Response\ResponseInterface;

use \Insomnia\Response;

abstract class View extends ArrayAccess implements ResponseInterface
{
    protected $path,
              $title        = '',
              $meta         = array(),
              $stylesheets  = array(),
              $scripts      = array(),
              $response     = null,
              $output       = '';
    
    public function render()
    {
        if( !file_exists( $this->getPath() ) || !is_readable( $this->getPath() ) )
        {
            throw new ViewException( 'Failed to load view file: ' . $this->getPath() );
        }
        
        $this->merge( $this->getResponse() );
        
        ob_start();
        require $this->getPath();
        $this->setOutput( ob_get_clean() );
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function setPath( $path )
    {        
        $this->path = $path;
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
    
    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput( $output )
    {
        $this->output = $output;
    }
    
    public function addStylesheet( $stylesheet )
    {
       $this->stylesheets[] = $stylesheet;
    }
    
    public function getStylesheets()
    {
        return $this->stylesheets;
    }

    public function setStylesheets( $stylesheets )
    {
        $this->stylesheets = $stylesheets;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle( $title )
    {
        $this->title = $title;
    }
    
    public function addMeta( $meta )
    {
       $this->v[] = $meta;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta( $meta )
    {
        $this->meta = $meta;
    }
    
    public function printStylesheetsAsHtml()
    {
        foreach( $this->getStylesheets() as $sheet )
        {
            echo '<link rel="stylesheet" href="'.$sheet.'" type="text/css" />' . PHP_EOL;
        }
    }

    public function printScriptsAsHtml()
    {
        foreach( array_reverse( $this->getScripts() ) as $script )
        {
            echo '<script src="'.$script.'" type="text/javascript"></script>' . PHP_EOL;
        }
    }
    
    public function addScript( $script )
    {
        $this->scripts[] = $script;
    }

    public function getScripts()
    {
        return $this->scripts;
    }

    public function setScripts( $scripts )
    {
        $this->scripts = $scripts;
    }

}