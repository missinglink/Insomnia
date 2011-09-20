<?php

namespace Insomnia\Kernel\Module\RestClient\Controller;

use \Insomnia\Controller\Action;
use \Insomnia\Kernel\Module\Mime\Response\Renderer\ViewRenderer;

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
     * @insomnia:View( "\Insomnia\Kernel\Module\RestClient\View\Client" )
     * @insomnia:Layout( "\Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function action()
    {
        $this->response[ 'controllers' ] = array( '/v1/test', '/ping' );
    }
}