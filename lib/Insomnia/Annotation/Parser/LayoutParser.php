<?php

namespace Insomnia\Annotation\Parser;

use \Insomnia\Pattern\ArrayAccess;

class LayoutParser extends ArrayAccess
{
    public function __construct( array $methodAnnotations )
    {
        foreach( $methodAnnotations as $annotation )
        {
            if( \get_class( $annotation ) == 'Insomnia\Annotation\Layout' )
            {
                $this->merge( $annotation );
            }
        }
    }
}
