<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Doctrine\Common\ClassLoader;
use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response\ResponseAbstract;
use \Insomnia\Response;
use \Symfony\Component\Yaml\Dumper;

class YamlRenderer extends ResponseAbstract implements ResponseInterface
{
    public function render()
    {       
        $classLoader = new ClassLoader( 'Symfony', \ROOT . 'lib' );
        $classLoader->register();

        $yamlDumper = new Dumper;
        echo $yamlDumper->dump( $this->getResponse()->toArray(), 2, 0 );
    }
}