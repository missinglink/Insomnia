<?php

namespace Insomnia;

use \Insomnia\ArrayAccess,
    \Insomnia\Response\Format\XmlRenderer,
    \Insomnia\Response\Format\JsonRenderer,
    \Insomnia\Response\Format\ViewRenderer,
    \Insomnia\Response\Format\ArrayRenderer,
    \Insomnia\Response\Format\YamlRenderer,
    \Insomnia\Response\Format\IniRenderer,
    \Insomnia\Response\Code,
    \Insomnia\Response\ResponseException;

class Response extends ArrayAccess
{
    private $renderer,
            $code       = Code::HTTP_OK,
            $mime,
            $charset    = 'utf8';

    public function __construct()
    {
        if( $_SERVER['REQUEST_METHOD'] === 'POST' )
            $this->code = Code::HTTP_CREATED;
    }

    public function prepare( $controller, $action, $request )
    {
        if( !isset( $this->mime ) )     $this->selectContentType( $request );
        if( !isset( $this->renderer ) ) $this->selectRenderer( $controller, $action );

        if( empty( $this->data ) && !( $this->renderer instanceof ViewRenderer ) )
            $this->setCode( Code::HTTP_NO_CONTENT );
    }

    public function render()
    {
        if( !\method_exists( $this->renderer, 'render' ) ) throw new ResponseException( 'Invalid Response Format' );

        \header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' ' . $this->code );
        \header( 'Content-Type: ' . $this->mime . '; charset=\'' . $this->charset .'\'' );
        $this->renderer->render( $this );
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

    public function selectContentType( $request )
    {
        foreach( \explode( ',', $request->getHeader( 'Accept' ) ) as $format )
        {
            $split = \explode( ';', $format );
            switch( \reset( $split ) )
            {
                case 'application/json':
                    return $this->setContentType( 'application/json' );

                case 'application/xml':
                case 'text/xml':
                    return $this->setContentType( 'application/xml' );

                case 'application/xhtml':
                case 'text/html':
                    return $this->setContentType( 'text/html' );

                case 'application/x-yaml':
                case 'text/yaml':
                    return $this->setContentType( 'application/x-yaml' );

               case 'text/plain':
                    return $this->setContentType( 'text/plain' );

               case 'text/ini':
                    return $this->setContentType( 'text/ini' );
            }
        }
        return $this->setContentType( 'application/json' );
    }

    public function selectRenderer( $controller, $action )
    {
        if( \strrpos( $this->mime, '/json' ) )
            $this->setRenderer( new JsonRenderer );

        elseif( \strrpos( $this->mime, '/xml' ) )
            $this->setRenderer( new XmlRenderer );

        elseif( \strrpos( $this->mime, '/x-yaml' ) ||
                \strrpos( $this->mime, '/yaml' ) )
            $this->setRenderer( new YamlRenderer );

        elseif( \strrpos( $this->mime, '/html' ) ||
                \strrpos( $this->mime, '/xhtml' ) )
        {
            $renderer = new ViewRenderer;
            $renderer->useView( $controller . '/' . $action );
            $this->setRenderer( $renderer );
        }

        elseif( \strrpos( $this->mime, '/plain' ) )
            $this->setRenderer( new ArrayRenderer );

        elseif( \strrpos( $this->mime, '/ini' ) )
            $this->setRenderer( new IniRenderer );
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode( $code )
    {
        $this->code = $code;
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
}