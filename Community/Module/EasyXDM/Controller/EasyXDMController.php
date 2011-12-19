<?php

namespace Community\Module\RestClient\Controller;

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
     * General purpose RESTful webservices client
     * 
     * Useful for testing that the server is behaving as expected.
     * 
     * @insomnia:Route("", name="client_index")
     * @insomnia:Method("GET")
     * @insomnia:Documentation( category="Webservice Client" )
     * 
     * @insomnia:View( "Community\Module\RestClient\View\Client" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function action()
    {
        $this->response[ 'controllers' ] = array( '/v1/test', '/ping' );
    }
}