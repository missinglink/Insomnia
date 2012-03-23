<?php

namespace Community\Module\Twilio\Controller;

use \Insomnia\Controller\Action;

/**
 * Twilio Controller
 * 
 * @Insomnia\Annotation\Resource
 * @Insomnia\Annotation\Route("/twilio")
 * 
 */
class TwilioController extends Action
{    
    /**
     * Twilio module for hack day
     * 
     * @Insomnia\Annotation\Route("", name="twilio_index")
     * @Insomnia\Annotation\Method("GET")
     * @Insomnia\Annotation\Documentation( category="Twilio" )
     * 
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function action()
    {
        $this->response[ 'controllers' ] = array( '/v1/test', '/ping' );
    }
}