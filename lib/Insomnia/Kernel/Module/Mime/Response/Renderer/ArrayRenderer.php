<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

use \Insomnia\Response\ResponseAbstract;

class ArrayRenderer extends ResponseAbstract implements ResponseInterface
{
    public function render()
    {
        \print_r( $this->getResponse()->toArray() );
    }
}