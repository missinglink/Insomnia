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
        
        $lowerCaseTrimBody = strtolower( trim( $sms->Body ) );
        
        if( 'join' == $lowerCaseTrimBody )
        {
            return $this->joinAction( $sms );
        }
        
        if( 'leave' == $lowerCaseTrimBody )
        {
            return $this->leaveAction( $sms );
        }
        
        if( 'who' == $lowerCaseTrimBody )
        {
            return $this->whoAction( $sms );
        }
        
        if( 'name' == substr( $lowerCaseTrimBody, 0, 4 ) )
        {
            return $this->nameAction( $sms );
        }
        
        if( 'info' == $lowerCaseTrimBody )
        {
            return $this->helpAction( $sms );
        }
        
        if( 'topic' == substr( $lowerCaseTrimBody, 0, 5 ) )
        {
            return $this->topicAction( $sms );
        }
        
        if( 'inviteall' == substr( $lowerCaseTrimBody, 0, 9 ) )
        {
            return $this->pubAction( $sms );
        }
        
        return $this->echoAction( $sms );
    }
    
    public function joinAction( Sms $sms )
    {
        $users = UserIndex::loadUsers();
        
        foreach( $users as $user )
        {
            if( $user->Phone == $sms->From )
            {
                header( 'application/xml' );
                echo '<Response>';
                echo '<Sms>You are already part of the conversation.</Sms>';
                echo '</Response>';
                die;
            }
        }
        
        // Save User
        $user = new User;
        $user->Name = Sms::DEFAULT_NAME;
        $user->Phone = $sms->From;
        
        // Save User Index
        $index = new UserIndex;
        $index->add( $user->getId() );
        
        header( 'application/xml' );
        echo '<Response>';
        echo '<Sms>You are now chatting with '.count( $users ).' other people. You can get help at any time by sending the word "info".</Sms>';
        echo '</Response>';
        die;
    }
    
    public function helpAction( Sms $sms )
    {
        header( 'application/xml' );
        echo '<Response>';
        echo '<Sms>Commands: join, leave, who, name xxxxx, topic xxxxx, help.</Sms>';
        echo '</Response>';
        die;
    }
    
    public function leaveAction( Sms $sms )
    {
        $users = UserIndex::loadUsers();
        $index = new UserIndex;
        
        foreach( $users as $user )
        {
            if( $user->Phone == $sms->From )
            {
                // Delete User from Index
                $index->remove( $user->getId() );
                
                header( 'application/xml' );
                echo '<Response>';
                echo '<Sms>You have left the conversation.</Sms>';
                echo '</Response>';
                die;
            }
        }

        header( 'application/xml' );
        echo '<Response>';
        echo '<Sms>You are not currently part of this conversation.</Sms>';
        echo '</Response>';
        die;
    }
    
    public function inviteAction( Sms $sms )
    {
        foreach( array_keys( Sms::$contacts ) as $contactNumber )
        {
            header( 'application/xml' );
            echo '<Response>';
            printf( '<Sms to="%s">%s</Sms>', $contactNumber, str_replace( 'inviteall ', '', $sms->Body ) );
            echo '</Response>';
            die;
        }
    }
    
    public function nameAction( Sms $sms )
    {
        $users = UserIndex::loadUsers();
        
        foreach( $users as $user )
        {
            if( $user->Phone == $sms->From )
            {
                $user->Name = trim( substr( $sms->Body, 4 ) );
                
                header( 'application/xml' );
                echo '<Response>';
                printf( '<Sms>Successfully set your name to: %s.</Sms>', $user->Name );
                echo '</Response>';
                die;
            }
        }
        
        header( 'application/xml' );
        echo '<Response>';
        echo '<Sms>You are not currently part of this conversation.</Sms>';
        echo '</Response>';
        die;
    }
    
    public function topicAction( Sms $sms )
    {
        header( 'application/xml' );
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<Response>';
        
        $topic = trim( substr( $sms->Body, 5 ) );
        
        foreach( UserIndex::loadUsers() as $user )
        {
            printf( '<Sms to="%s">%s set the topic: %s.</Sms>', $user->Phone, $sms->guessName(), $topic );
        }
        
        echo '</Response>';
        die;
    }
    
    public function whoAction( Sms $sms )
    {
        header( 'application/xml' );
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<Response>';
        
        $people = array();
        foreach( UserIndex::loadUsers() as $user )
        {
            $people[] = $user->Name;
        }
        
        if( count( $people ) )
        {
            printf( '<Sms>You are chatting with: %s.</Sms>', implode( ', ', $people ) );
        }
        
        else
        {
            echo '<Sms>There is currently no-one in this conversation.</Sms>';
        }
        
        echo '</Response>';
        die;
    }
    
    public function echoAction( Sms $sms )
    {
        header( 'application/xml' );
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<Response>';
        
        $users = UserIndex::loadUsers();
        
        foreach( $users as $user )
        {
            // In index
            if( $user->Phone == $sms->From )
            {
                if( count( $users ) > 1 )
                {
                    // Send to everyone else
                    foreach( $users as $user2 )
                    {
                        if( $user->Phone != $user2->Phone )
                        {
                            printf( '<Sms to="%s">%s: %s</Sms>', $user2->Phone, $sms->guessName(), $sms->Body );
                        }
                    }

                    echo '</Response>';
                    die;   
                }
                
                else
                {
                    echo '<Sms>There is no-one else currently in this conversation.</Sms>';
                    echo '</Response>';
                    die;
                }
            }
        }
        
        echo '<Sms>You are not currently part of this conversation.</Sms>';
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
        $this->logToDisk( 'call' );
        
        new \Application\Module\RedisExample\Bootstrap\Redis;
        $smsIndex = SmsIndex::loadAll();
     
        header( 'application/xml' );
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<Response>';
        
        foreach( $smsIndex as $sms )
        {
            $lowerCaseTrimBody = strtolower( trim( $sms->Body ) );

            if( 'join' == $lowerCaseTrimBody ||
                'leave' == $lowerCaseTrimBody ||
                'who' == $lowerCaseTrimBody ||
                'name' == substr( $lowerCaseTrimBody, 0, 4 ) ||
                'info' == $lowerCaseTrimBody )
            {
                continue;
            }
            
            printf( '<Say voice="woman">%s</Say>', $sms->guessName() );
            printf( '<Say>%s</Say>', $sms->Body );
        }
        
        echo '</Response>';
        die;
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