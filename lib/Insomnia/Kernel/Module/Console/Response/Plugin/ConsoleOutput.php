<?php

namespace Insomnia\Kernel\Module\Console\Response\Plugin;

use \Insomnia\Pattern\Observer,
    \Insomnia\Registry;

class ConsoleOutput extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        Registry::set( 'default_content_type',  'text/ini' );
    }
}