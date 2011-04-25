<?php

namespace Insomnia;

use \Insomnia\ArrayAccess,
    \Insomnia\Response\Format\JsonRenderer,
    \Insomnia\Response\Code;

class Response extends ArrayAccess
{
    private $renderer,
            $code = Code::HTTP_OK;

    public function render()
    {
        if( !isset( $this->renderer ) ) $this->setRenderer( new JsonRenderer );
        if( empty( $this->data ) ) $this->setCode( Code::HTTP_NO_CONTENT );

        \header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' ' . $this->code );
        $this->renderer->render( $this );
    }

    public function setRenderer( $renderer )
    {
        $this->renderer = $renderer;
    }

    public function setCode( $code )
    {
        $this->code = $code;
    }
}