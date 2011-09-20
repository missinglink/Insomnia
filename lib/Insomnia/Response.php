<?php

// @todo requires cleanup

namespace Insomnia;

use \Insomnia\Pattern\ArrayAccess,
    \Insomnia\Response\ResponseException;

use \Insomnia\Dispatcher\Endpoint;

class Response extends ArrayAccess implements \SplSubject
{
    private $code       = null,
            $mime       = '',
            $renderer   = null,
            $ttl        = 0,
            $charset    = 'utf8',
            $endPoint   = null;
    
    /** Response Graph Modifiers **/
    private $modifiers  = array();
    
    /** Subject Pattern **/
    protected $observers = array();

    public function render( Endpoint $endPoint )
    {
        $this->setEndPoint( $endPoint );
        
        foreach( \Insomnia\Kernel::getInstance()->getResponsePlugins() as $plugin )
        {
            $this->attach( $plugin );
        }

        $this->notify();
        $this->runModifiers();
        
        if( !\method_exists( $this->getRenderer(), 'render' ) )
            throw new ResponseException( 'Invalid Response Renderer' );
        
        $this->getRenderer()->setResponse( $this );
        $this->getRenderer()->render();
        
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
    
    /** @return \Insomnia\Dispatcher\Endpoint */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    public function setEndPoint( Endpoint $endPoint )
    {
        $this->endPoint = $endPoint;
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