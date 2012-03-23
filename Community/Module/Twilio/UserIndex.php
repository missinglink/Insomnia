<?php

namespace Community\Module\Twilio;

use \Insomnia\Controller\NotFoundException;

class UserIndex extends RedisSetAbstract
{
    const KEY = 'user';
    
    public static function loadUsers()
    {
        $return = array();
        
        // Access the index
        $userIndex = new self;
        
        if( !$userIndex->getLength() ) return $return;
        
        foreach( $userIndex->getIterator() as $indexValue )
        {
            $user = new User;
            $user->setId( $indexValue );

            $return[] = $user;
        }
        
        return $return;
    }
}