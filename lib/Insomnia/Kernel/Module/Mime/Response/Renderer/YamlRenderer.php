<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Doctrine\Common\ClassLoader;
use \Insomnia\Response\ResponseInterface;
use \Insomnia\Response;
use \Symfony\Component\Yaml\Dumper;

class YamlRenderer implements ResponseInterface
{
    public function render( Response $response )
    {
        $classLoader = new ClassLoader( 'Symfony', \ROOT . 'lib' );
        $classLoader->register();

        $yamlDumper = new Dumper;
        echo $yamlDumper->dump( $response->toArray(), 2, 0 );
    }
}