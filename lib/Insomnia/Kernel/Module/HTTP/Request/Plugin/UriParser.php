<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Pattern\Observer;

/**
 * Parse the request URI from the $_SERVER['REQUEST_URI'] global and add the
 * resulting information to the Insomnia request object.
 */
class UriParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        // If a request URI is passed via CGI params
        if( isset( $_SERVER['REQUEST_URI'] ) )
        {
            // Parse url and add results to request object
            $request->mergeParams( parse_url( $_SERVER['REQUEST_URI'] ) );
        }
    }
}