<?php

namespace Application\Module\RedisExample\Entities;

require_once( \ROOT . 'lib/rediska/library/Rediska/Key/Set.php' );

class Tests extends \Rediska_Key_Set
{
    public function __construct()
    {
        return parent::__construct( Test::KEY . '_index' );
    }
}
