<?php

namespace Application\Controller;

use \Insomnia\Controller\Action;

/**
 * Client Controller
 * 
 * @webservice:Resource
 * @webservice:Route("/client.*")
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
     * @webservice:Route("", name="client_index")
     * @webservice:Method("GET")
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