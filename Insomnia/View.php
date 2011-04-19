<?php

namespace Insomnia;

class View
{
    private $_viewPath = array();

    public function setViewPath( $path )
    {
        $this->_viewPath = \realpath( $path ) . \DIRECTORY_SEPARATOR;
    }

    public function render( $name )
    {
        \ob_start();
        include( $this->_viewPath . \DIRECTORY_SEPARATOR . $name . '.phtml' );
        \ob_end_flush();
    }
}