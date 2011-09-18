<?php

namespace Insomnia;

use \Insomnia\Pattern\ArrayAccess,
    \Insomnia\Response\ResponseException;

use \Insomnia\Dispatcher\Endpoint;

class Response extends ArrayAccess implements \SplSubject
{
    private $code       = null,
            $mime       = null,
            $renderer   = null,
            $modifiers  = array(),
            $ttl        = 0,
            $charset    = 'utf8',
            $view       = 'index';

    public function render( Endpoint $endPoint )
    {       
        foreach( \Insomnia\Kernel::getInstance()->getResponsePlugins() as $plugin )
        {
            $this->attach( $plugin );
        }
        
        $this->notify();
        
        if( !\method_exists( $this->renderer, 'render' ) )
            throw new ResponseException( 'Invalid Response Format' );

        $this->runModifiers();
        $this->renderer->render( $this );
        \flush();
        exit;
    }

    public function getRenderer()
    {
        return $this->renderer;
    }

    public function setRenderer( $renderer )
    {
        $this->renderer = $renderer;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode( $code )
    {
        $this->code = $code;
    }

    public function getTimeToLive()
    {
        return $this->ttl;
    }

    public function setTimeToLive( $ttl = 0 )
    {
        $this->ttl = $ttl;
    }

    public function getContentType()
    {
        return $this->mime;
    }

    public function setContentType( $mime )
    {
        $this->mime = $mime;
    }

    public function getCharacterSet()
    {
        return $this->charset;
    }

    public function setCharacterSet( $charset )
    {
        $this->charset = $charset;
    }
    
    public function getView()
    {
        return $this->view;
    }

    public function setView( $view )
    {
        $this->view = $view;
    }
    
    public function addModifier( $map )
    {
        $this->modifiers[] = $map;
    }

    public function runModifiers()
    {
        foreach( $this->modifiers as $modifier )
        {
            if( \method_exists( $modifier, 'render' ) ) $modifier->render( $this );
        }
    }

    /** Subject Pattern **/
    protected $observers = array();

    public function attach( \SplObserver $observer )
    {
        $this->observers[] = $observer;
    }

    public function detach( \SplObserver $observer )
    {
        if( false !== ( $key = \array_search( $observer, $this->observers ) ) )
        {
            unset( $this->observers[ $key ] );
        }
    }

    public function notify()
    {
        foreach( $this->observers as $observer )
        {
            $observer->update( $this );
        }
    }
}