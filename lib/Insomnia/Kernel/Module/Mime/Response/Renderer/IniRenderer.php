<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

class IniRenderer implements ResponseInterface
{
    private $indent = '   ';
    
    public function render( Response $response )
    {
        \ob_start();
        $this->createIni( $response->toArray() );
        echo \trim( \ob_get_clean() );
        echo PHP_EOL;
    }

    private function createIni( $data, $indent = 0 )
    {
        foreach( $data as $key => $val )
        {
            $key = \is_numeric( $key ) ? 'item' : $key;
            
            if( \is_array( $val ) )
            {
                echo PHP_EOL . \str_repeat( $this->indent, $indent ) . "[$key]\r\n";
                $this->createIni( $val, $indent + 1 );
            }
            
            elseif( is_scalar( $val ) )
            {
                echo \str_repeat( $this->indent, $indent ) . "$key = " . ( \is_numeric( $val ) ? $val : '"'.$val.'"' ) . "\r\n";
            }
            
            elseif( is_object( $val ) )
            {
                echo \str_repeat( $this->indent, $indent ) . "$key = { Object : " . get_class( $val ) . ' }' .PHP_EOL;
            }
            
            else {
                echo \str_repeat( $this->indent, $indent ) . "$key = [RENDER ERROR]" . PHP_EOL;
            }
        }
    }
}