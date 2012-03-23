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
//        $this->response[ 'Sms' ] = 'Hello World';
//        $this->response[ 'Redirect' ] = 'http://164.177.147.208/twilio/sms2.xml';
        
        $this->logToDisk( 'sms' );
        
        if( !isset( $_REQUEST[ 'Caller' ] ) )
        {
            $this->logToDisk( 'error' );
        }
        
        $this->response[ 'Sms' ] = 'Hello ' . $this->mapPhoneNumberToName( $_REQUEST[ 'Caller' ] );
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
    
    private function mapPhoneNumberToName( $phone )
    {
        $contacts = $this->getContacts();
        
        if( isset( $contacts[ $phone ] ) )
        {
            return $contacts[ $phone ];
        }
        
        return 'Anonymous';
    }
    
    private function getContacts()
    {
        return array(
            '+447999025876'  => 'Aaron Kato',
            '+447883759170'  => 'Charlie Duff',
            '+447734867218'  => 'Dan Thorpe',
            '+447837252976'  => 'Ed Kendall',
            '+447943048020'  => 'Elvis Ciotti',
            '+447868493510'  => 'Fabrizio Moscon',
            '+447837566236'  => 'Gordon Dent',
            '+447770667578'  => 'James Mayes',
            '+447972720606'  => 'Janna Bastow',
            '+447932677441'  => 'Justin Robinson',
            '+4477886163463' => 'Karen von Grabowiecki',
            '+447999206555'  => 'Karol Grecki',
            '+447946473945'  => 'Linus Norton',
            '+14084218255'   => 'Master Burnett',
            '+447706170600'  => 'Matt Knoll',
            '+447771603207'  => 'Neel Upadhyaya',
            '+447876572123'  => 'Perry Harlock',
            '+447946789055'  => 'Peter Johnson',
            '+447768006004'  => 'Phil Booth',
            '+447722135516'  => 'Ralph Schwaninger',
            '+447895872912'  => 'Ramon Bez',
            '+447548566961'  => 'Robert Peake',
            '+447595365905'  => 'Rowan Manning',
            '+447748961545'  => 'Si Hammond',
            '+447869282548'  => 'Tom Alterman',
            '+447773036604'  => 'Tom Michaelis'
        );
    }
}