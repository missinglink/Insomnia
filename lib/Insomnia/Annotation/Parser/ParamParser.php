<?php

namespace Insomnia\Annotation\Parser;

use \Insomnia\Pattern\ArrayAccess;

class ParamParser extends ArrayAccess
{
    public function __construct( array $methodAnnotations )
    {           
        foreach( $methodAnnotations as $annotation )
        {
            if( \get_class( $annotation ) == 'Insomnia\Annotation\Request' )
            {
                foreach( $annotation['value'] as $param )
                {
                    $p = $param->toArray();
                    $p[ 'required' ] = true;
                    $this[] = $p;
                }
            }
        }
    }
}
