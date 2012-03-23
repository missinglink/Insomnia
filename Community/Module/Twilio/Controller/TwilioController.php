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
        $this->response[ 'Sms' ] = 'Hello World';
        $this->response[ 'Redirect' ] = 'http://164.177.147.208/twilio/sms2.xml';
        
        $this->logToDisk( 'sms' );
    }
    
    /**
     * Twilio module for hack day
     * 
     * @Insomnia\Annotation\Route("/sms2", name="twilio_sms2")
     * @Insomnia\Annotation\Method("POST")
     * @Insomnia\Annotation\Documentation( category="Twilio" )
     * 
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function smsTwo()
    {
        $this->response[ 'Sms' ] = 'Second Message';
        
        $this->logToDisk( 'sms2' );
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