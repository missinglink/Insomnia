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
     * @Insomnia\Annotation\Route("/call", name="twilio_call")
     * @Insomnia\Annotation\Method("POST")
     * @Insomnia\Annotation\Documentation( category="Twilio" )
     * 
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function call()
    {
        $this->response[ 'Say' ] = 'Hello World';
        
        $this->logToDisk( 'call' );
    }
    
    /**
     * Twilio module for hack day
     * 
     * @Insomnia\Annotation\Route("/sms", name="twilio_sms")
     * @Insomnia\Annotation\Method("POST")
     * @Insomnia\Annotation\Documentation( category="Twilio" )
     * 
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function sms()
    {
        $this->logToDisk( 'sms' );
        
        $sms = new Sms;
        $sms->import( $_REQUEST );
        
        $this->response[ 'Sms' ] = 'Hi ' . $sms->FromName;
    }
    
    /**
     * Twilio module for hack day
     * 
     * @Insomnia\Annotation\Route("/contacts", name="twilio_contacts")
     * @Insomnia\Annotation\Method("GET")
     * @Insomnia\Annotation\Documentation( category="Twilio" )
     * 
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function contacts()
    {
        $this->response->merge( $this->getContacts() );
    }
    
    /**
     * Twilio module for hack day
     * 
     * @Insomnia\Annotation\Route("/status", name="twilio_status")
     * @Insomnia\Annotation\Method("POST")
     * @Insomnia\Annotation\Documentation( category="Twilio" )
     * 
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function status()
    {
        $this->logToDisk( 'status' );
    }
    
    /**
     *
     * @param type $type 
     */
    private function logToDisk( $type )
    {
        $file = tempnam( '/tmp', 'twilio-' . $type . '-' );
        
        file_put_contents( $file, print_r( $_REQUEST, true ), \FILE_APPEND );
        file_put_contents( $file, print_r( $_SERVER, true ), \FILE_APPEND );
    }
}