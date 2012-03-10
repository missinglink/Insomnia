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
            $charset    = 'UTF-8',
            $endPoint   = null,
            $headers    = array();
    
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
        
        if( !\method_exists( $this->getRenderer(), 'render' ) )
            throw new ResponseException( 'Invalid Response Renderer' );
        
        $this->flushHeaders();
        $this->getRenderer()->setResponse( $this );
        $this->getRenderer()->render();
        
        \flush();
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
    
    // Response Headers
    
    public function getHeader( $key )
    {
        return isset( $this->headers[ $key ] ) ? $this->headers[ $key ] : false;
    }

    public function setHeader( $key, $value )
    {
        $this->headers[ $key ] = $value;
    }
    
    public function getHeaders()
    {
        return $this->headers;
    }
    
    private function flushHeaders()
    {
        foreach( $this->getHeaders() as $key => $value )
        {
            header( $key . ': ' . $value );
        }
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