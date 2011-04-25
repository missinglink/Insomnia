<?php

namespace Application\Bootstrap;

use \Doctrine\Common\ClassLoader;

class Insomnia
{
    public function __construct()
    {
        $classLoader = new ClassLoader( 'Insomnia', '../lib' );
        $classLoader->register();
    }
}