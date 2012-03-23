<?php

namespace Community\Module\Twilio;

class SmsIndex extends RedisSetAbstract
{
    const KEY = 'sms';
    
    public static function loadAll()
    {
        $return = array();
        
        // Access the index
        $smsIndex = new self;
        
        if( !$smsIndex->getLength() ) return $return;
        
        foreach( $smsIndex->getIterator() as $indexValue )
        {
            $sms = new Sms;
            $sms->setId( $indexValue );

            $return[] = $sms;
        }
        
        return $return;
    }
}