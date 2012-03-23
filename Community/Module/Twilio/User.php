<?php

namespace Community\Module\Twilio;

class User extends RedisHashAbstract
{
    const KEY = 'user';
    
//    public $Phone;
//    public $Name;
    
    public function __get( $name )
    {
        if( $name === 'Name' )
        {
            $userName = parent::__get( 'Name' );

            if( empty( $userName ) || $userName === Sms::DEFAULT_NAME )
            {
                $userPhone = parent::__get( 'Phone' );
                
                if( isset( Sms::$contacts[ $userPhone ] ) )
                {
                    return Sms::$contacts[ $userPhone ];
                }
            }
            
            return $userName;
        }
        
        return parent::__get( $name );
    }
}