<?php

namespace Insomnia\Kernel\Module\HTTP\Response\Plugin;

use \Insomnia\Pattern\Observer;

class ContentTypeHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        $response->setHeader( 'Content-Type:', $response->getContentType() . '; charset=' . $response->getCharacterSet() );
    }
}