<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Pattern\Observer;

class ParamParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        // Trim params
        $requestParams = array_map( 'trim', $_REQUEST );
        
        // Remove blank params
        $requestParams = array_diff( $requestParams, array( '', null ) );
        
        // Merge in to request object
        $request->mergeParams( $requestParams );
        
        // If a request URI is passed via CGI params
        if( isset( $_SERVER['REQUEST_URI'] ) )
        {
            // Parse url and add results to request object
            $request->mergeParams( parse_url( $_SERVER['REQUEST_URI'] ) );
        }
    }
}