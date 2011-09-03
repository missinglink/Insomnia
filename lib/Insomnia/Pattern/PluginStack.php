<?php

namespace Insomnia\Pattern;

class PluginStack extends \ArrayObject
{
    public function offsetSet( $index, $newval )
    {
        if ( $value instanceof \Insomnia\Pattern\Plugin )
        {
            parent::offsetSet( $index, $newval );
        }
        
        else throw new \Exception( 'Invalid Plugin Specified' );
    }
}