<?php

namespace Insomnia\Response\Format;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

class YamlRenderer implements ResponseInterface
{
    public function render( Response $response )
    {
        $yamlDumper = new \Symfony\Component\Yaml\Dumper;
        echo $yamlDumper->dump( $response->toArray(), 2, 0 );
    }
}