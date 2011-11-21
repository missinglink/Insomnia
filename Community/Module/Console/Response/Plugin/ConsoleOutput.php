<?php

namespace Community\Module\Console\Response\Plugin;

use \Insomnia\Pattern\Observer,
    \Insomnia\Registry;

class ConsoleOutput extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        $response->setContentType( 'text/ini' );
    }
}