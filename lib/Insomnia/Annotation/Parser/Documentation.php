<?php

namespace Insomnia\Annotation\Parser;

use \Insomnia\Pattern\ArrayAccess;

class Documentation extends ArrayAccess
{
    public function __construct( array $methodAnnotations )
    {
        foreach( $methodAnnotations as $annotation )
        {
            if( \get_class( $annotation ) == 'Insomnia\Annotation\Documentation' )
            {
                $this->merge( $annotation );
            }
        }
    }
}
