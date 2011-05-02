<?php

namespace Application\Controller\Status;

use \Application\Controller\StatusController;

class StatusAction extends StatusController
{
    public function action()
    {
        $this->request->getHeader( 'Load' );
        $this->response->merge( array(
            'meta'    => $this->request->getHeaders(),
            'body'    => $this->request->toArray()
        ) );
    }
}