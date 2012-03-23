<?php

namespace Community\Module\Twilio;

class Sms extends RedisHashAbstract
{
    const KEY = 'sms';
    const DEFAULT_NAME = 'Anonymous';
    
//    public $AccountSid;
//    public $Body;
//    public $ToZip;
//    public $FromState;
//    public $ToCity;
//    public $SmsSid;
//    public $ToState;
//    public $To;
//    public $ToCountry;
//    public $FromCountry;
//    public $SmsMessageSid;
//    public $ApiVersion;
//    public $FromCity;
//    public $SmsStatus;
//    public $From;
//    public $FromZip;
//    
    public static $contacts = array(
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
    
    public function import( array $array )
    {
        foreach( $array as $key => $value )
        {
            if( substr( $key, 0, 1 ) !== '_' )
            {
                $this->{ $key } = $value;
            }
        }
    }
    
    public function guessName()
    {
        $users = UserIndex::loadUsers();
        
        foreach( $users as $user )
        {
            if( $user->Phone == $this->From )
            {
                return $this->loadNameFromFixturesIfNotSpecified( $user );
            }
        }
        
        return self::DEFAULT_NAME;
    }
    
    public function loadNameFromFixturesIfNotSpecified( User $user )
    {
        $userName = $user->Name;
        
        if( empty( $userName ) || $userName === self::DEFAULT_NAME )
        {
            if( isset( self::$contacts[ $this->From ] ) )
            {
                return self::$contacts[ $this->From ];
            }
        }
        
        return self::DEFAULT_NAME;
    }
}