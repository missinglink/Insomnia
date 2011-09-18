<?php

namespace Insomnia\Pattern;

use \Insomnia\Kernel;

abstract class KernelModule
{
    protected $basePath = '';
    
    public function getBasePath()
    {
        return $this->basePath;
    }

    public function setBasePath( $basePath )
    {
        $this->basePath = $basePath;
    }
    
    abstract public function bootstrap( Kernel $kernel );
}