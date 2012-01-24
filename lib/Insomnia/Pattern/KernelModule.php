<?php

namespace Insomnia\Pattern;

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
    
    abstract public function run();
}