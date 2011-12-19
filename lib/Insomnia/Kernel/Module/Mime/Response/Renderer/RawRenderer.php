<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

use \Insomnia\Response\ResponseAbstract;

class RawRenderer extends ResponseAbstract implements ResponseInterface
{
    public function render()
    {
        echo $this->getResponse()->toArray();
    }
}