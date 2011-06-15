<?php

namespace Insomnia\Annotation\Parser;

use Insomnia\Router\RouteStack;
use Insomnia\Router\AnnotationReader;

class ViewParser extends \Insomnia\ArrayAccess
{
    public function __construct( array $methodAnnotations )
    {
        foreach( $methodAnnotations as $annotation )
        {
            if( \get_class( $annotation ) == 'Insomnia\Annotation\View' )
            {
                $this->merge( $annotation );
            }
        }
    }
}
