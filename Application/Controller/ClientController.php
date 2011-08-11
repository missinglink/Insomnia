<?php

namespace Application\Controller;

use \Insomnia\Controller\Action;

/**
 * Client Controller
 * 
 * @insomnia:Resource
 * @insomnia:Route("/client.*")
 * 
 */
class ClientController extends Action
{
    public function __construct()
    {
        parent::__construct();
        $this->response->setContentType( 'text/html' );
    }
    
    /**
     * Map Errors to Output
     * 
     * Something that spans
     * multiple lines.
     * 
     * @insomnia:Route("", name="client_index")
     * @insomnia:Method("GET")
     * 
     */
    public function action()
    {
        $renderer = new \Insomnia\Response\Renderer\ViewRenderer;
        $renderer->useView( 'client/client' );
        $this->getResponse()->setRenderer( $renderer );

        $this->response[ 'controllers' ] = array( '/v1/test', '/ping' );
    }
}