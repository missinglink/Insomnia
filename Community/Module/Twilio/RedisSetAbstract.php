<?php

namespace Community\Module\Twilio;

require_once( \ROOT . 'lib/rediska/library/Rediska/Key/Set.php' );

class RedisSetAbstract extends \Rediska_Key_Set
{
    const KEY = RedisHashAbstract::KEY;
    
    public function __construct()
    {
        return parent::__construct( static::KEY . '_index' );
    }
}