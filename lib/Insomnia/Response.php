<?php

namespace Insomnia;

use \Insomnia\ArrayAccess,
    \Insomnia\Response\Format\JsonRenderer,
    \Insomnia\Response\Code;

class Response extends ArrayAccess
{
    private $renderer,
            $code       = Code::HTTP_OK,
            $mime       = 'application/json',
            $charset    = 'UTF8';

    public function render()
    {
        if( !isset( $this->renderer ) ) $this->setRenderer( new JsonRenderer );
        if( empty( $this->data ) ) $this->setCode( Code::HTTP_NO_CONTENT );

        \header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' ' . $this->code );
        \header( 'Content-type: ' . $this->mime . '; charset=\'' . $this->charset .'\'' );
        $this->renderer->render( $this );
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