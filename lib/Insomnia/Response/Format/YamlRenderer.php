<?php

namespace Insomnia\Response\Format;

use \Doctrine\Common\ClassLoader;
use \Insomnia\Response\ResponseInterface;
use \Insomnia\Response;

class YamlRenderer implements ResponseInterface
{
    public function render( Response $response )
    {
        $classLoader = new ClassLoader( 'Symfony', \ROOT . 'lib' );
        $classLoader->register();

        $yamlDumper = new \Symfony\Component\Yaml\Dumper;
        echo $yamlDumper->dump( $response->toArray(), 2, 0 );
    }
}