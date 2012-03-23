<?php

namespace Community\Module\Twilio\Controller;

use \Insomnia\Controller\Action;
use \Community\Module\Twilio\Sms;
use \Community\Module\Twilio\SmsIndex;
use \Community\Module\Twilio\User;
use \Community\Module\Twilio\UserIndex;

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
        
        new \Application\Module\RedisExample\Bootstrap\Redis;
        
        // Save Sms
        $sms = new Sms;
        $sms->import( $_REQUEST );
        
        // Save Sms Index
        $index = new SmsIndex;
        $index->add( $sms->getId() );
        
        switch( strtolower( trim( $sms->Body ) ) )
        {
            case 'join' : return $this->joinAction( $sms );
            case 'who' : return $this->whoAction( $sms );
            default : return $this->echoAction( $sms );
        }
    }
    
    /**
     * 
     */
    public function joinAction( Sms $sms )
    {
//        if( $sms->guessName() === Sms::DEFAULT_NAME )
//        {
//            $this->response[ 'Sms' ] = 'What\'s your name?';
//            
//            return;
//        }
        
        $num = 'x';
        $to = '';
        
        header( 'application/xml' );
        echo '<Response>';
        echo '<Sms to="'.$to.'">You are discussing Hack Day with '.$num.' other people</Sms>';
        echo '</Response>';
        die;
    }
    
    public function echoAction( Sms $sms )
    {
        header( 'application/xml' );
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<Response>';
        
        foreach( UserIndex::loadUsers() as $user )
        {
            if( $user->Phone != $sms->From )
            {
                printf( '<Sms to="%s">%s: %s</Sms>', $user->Phone, $user->Name, $sms->Body );
            }
        }
        
        echo '</Response>';
        die;
    }
    
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