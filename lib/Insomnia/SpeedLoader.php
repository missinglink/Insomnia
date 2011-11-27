<?php

namespace Insomnia;

use \DomainException;

class SpeedLoader
{
    static $namespaceSeparator = '\\';
    private $namespaces = array();

    /**
     * Registers a new top-level namespace to match.
     *
     * @param string $namespace The namespace name to add.
     * @param string $path The path to the namespace (without the namespace name itself).
     * @param string $extension The namespace file extension.
     */
    public function addNamespace( $namespace, $path, $extension = '.php' )
    {
        $this->namespaces[ $namespace ] = DIRECTORY_SEPARATOR . trim( $path, \DIRECTORY_SEPARATOR ) . \DIRECTORY_SEPARATOR;
        
        return $this;
    }

    /**
     * Checks if the specified top-level namespace is available.
     *
     * @param string $namespace The namespace name to check.
     */
    public function hasNamespace($namespace)
    {
        return isset( $this->namespaces[ $namespace ] );
    }

    /**
     * Removes a registered top-level namespace.
     *
     * @param string $namespace The namespace name to remove.
     */
    public function removeNamespace($namespace)
    {
        if( !isset( $this->namespaces[ $namespace ] ) )
        {
            throw new DomainException( 'The namespace ' . $namespace . ' is not available.' );
        }
        
        unset( $this->namespaces[ $namespace ] );
    }

    /**
     * Installs this class loader on the SPL autoload stack.
     */
    public function register()
    {
        spl_autoload_register( array( $this, 'loadClass' ) );
    }

    /**
     * Uninstalls this class loader from the SPL autoloader stack.
    */
    public function unregister()
    {
        spl_autoload_unregister( array( $this, 'loadClass' ) );
    }

    /**
     * Loads the given class or interface.
     *
     * @param string $classPath The name of the class to load.
     * @return void
     */
    public function loadClass( $classPath )
    {
        $classPath = str_replace( array( self::$namespaceSeparator, '_' ), \DIRECTORY_SEPARATOR, $classPath );
        $namespace = strstr( $classPath, \DIRECTORY_SEPARATOR, true );
        
        return isset( $this->namespaces[ $namespace ] )
            ? require $this->namespaces[ $namespace ] . $classPath . '.php'
            : false;
    }
}