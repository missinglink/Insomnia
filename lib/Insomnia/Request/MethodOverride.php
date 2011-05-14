<?php

namespace Insomnia\Request;

use \Insomnia\Pattern\Observer;

class MethodOverride extends Observer
{
    const PARAM = '_method';
    const HEADER = 'X-Method-Override';

    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        /* Override Via Param */
        if( $request->hasParam( self::PARAM ) )
        {
            $method = $request->getParam( self::PARAM );
            $request->setMethod( $method );
            $request->setHeader( self::HEADER, $method );
        }

        /* Override Via Header */
        elseif( null !== ( $method = $request->getHeader( self::HEADER ) ) )
        {
            $request->setMethod( $method );
        }
    }
}