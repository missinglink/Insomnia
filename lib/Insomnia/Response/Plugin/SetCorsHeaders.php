<?php

namespace Insomnia\Response\Plugin;

use \Insomnia\Pattern\Observer;

class SetCorsHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        // Cross Origin Resource Sharing (CORS) Headers
        \header( 'Access-Control-Allow-Origin: *' );
        \header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, TRACE, STATUS, OPTIONS' );
        \header( 'Access-Control-Allow-Headers: X-Requested-With' );
    }
}