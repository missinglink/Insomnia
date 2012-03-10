<?php

namespace Community\Module\RestClient\Controller;

use \Insomnia\Controller\Action;

/**
 * Client Controller
 * 
 * Insomnia\Annotation\:Resource
 * Insomnia\Annotation\:Route("/client.*")
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
     * Insomnia\Annotation\:Route("", name="client_index")
     * Insomnia\Annotation\:Method("GET")
     * Insomnia\Annotation\:Documentation( category="Webservice Client" )
     * 
     * Insomnia\Annotation\:View( "Community\Module\RestClient\View\Client" )
     * Insomnia\Annotation\:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function action()
    {
        $this->response[ 'controllers' ] = array( '/v1/test', '/ping' );
    }
}