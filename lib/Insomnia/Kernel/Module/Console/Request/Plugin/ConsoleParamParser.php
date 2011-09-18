<?php

namespace Insomnia\Kernel\Module\Console\Request\Plugin;

use \Insomnia\Pattern\Observer;

class ConsoleParamParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        // @todo, this is ugly
        if( isset( $_SERVER[ 'argv' ][ 1 ] ) )
        {
            $urlVars = explode( ' ', $_SERVER[ 'argv' ][ 1 ] );

            if( isset( $urlVars[ 0 ] ) )
            {
                $request->setMethod( $urlVars[ 0 ] );
            }

            if( isset( $urlVars[ 1 ] ) )
            {
                $request->setParam( 'path', $urlVars[ 1 ] );
            }
        }
    }
}