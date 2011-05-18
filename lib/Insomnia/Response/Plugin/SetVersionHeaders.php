<?php

namespace Insomnia\Response\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Registry;

class SetVersionHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        /* @var $request \Insomnia\Request */
        if( Registry::get( 'request' )->hasParam( 'version' ) )
            \header( 'X-Version : ' . Registry::get( 'request' )->getParam( 'version' ) );
    }
}