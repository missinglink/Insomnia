<?php

namespace Community\Module\Twilio;

class UserIndex extends RedisSetAbstract
{
    const KEY = 'user';
    
    public static function loadUsers()
    {
        $user = new User;
        $user->Phone = '+447946789055';
        $user->Name = 'Peter Johnson';
        
        $user2 = new User;
        $user2->Phone = '+447734867218';
        $user2->Name = 'Dan Thorpe';
        
        $user3 = new User;
        $user3->Phone = '+447722135516';
        $user3->Name = 'Ralph Schwaninger';
        
        return array(
            $user,
            $user2,
            $user3
        );
    }
}