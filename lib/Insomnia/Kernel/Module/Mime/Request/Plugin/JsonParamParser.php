<?php

namespace Insomnia\Kernel\Module\Mime\Request\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Kernel\Module\Mime\Response\Content;

class JsonParamParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        // Get the raw request body
        $body = $request->getBody();
        
        if( strlen( $body ) > 0 )
        {
            if( Content::TYPE_JSON === $request->getContentType() )
            {
                $json = json_decode( $body, true );
                
                if( null !== $json )
                {
                    $request->mergeParams( $json );
                }
            }
        }
    }
}