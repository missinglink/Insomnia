<?php

namespace Insomnia;

require_once __DIR__ . '/SpeedLoader.php';

class FlexiLoader extends SpeedLoader
{
    /**
     * Loads the given class or interface.
     *
     * @param string $classPath The name of the class to load.
     * @return void
     */
    public function loadClass( $classPath )
    {
        foreach( array_reverse( $this->namespaces ) as $key => $value )
        {            
            if( preg_match( '_^(?<namespace>' . preg_quote( $key ) . '.*)$_', $classPath, $matches ) )
            {
                if( $firstClass = strstr( $key, self::$namespaceSeparator, true ) )
                {
                    $matches[ 'namespace' ] = str_replace( $firstClass . self::$namespaceSeparator, '', $classPath );
                }

                if( include( $value . str_replace( array( self::$namespaceSeparator, '_' ), \DIRECTORY_SEPARATOR, $matches[ 'namespace' ] ) . '.php' ) )
                {
                    return true;
                }
            }
        };
        
        return false;
    }
    
    public function addAlias( $alias, $namespace )
    {
        $this->namespaces[ $alias ] = $this->namespaces[ $namespace ];
    }
}