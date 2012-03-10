<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Content
{
    public $size = -1;
    public $mimeType = '';
    public $text = '';
    
    /**
     * @param string $mimeType
     * @param string $text
     * @throws \UnexpectedValueException 
     */
    public function __construct( $mimeType, $text )
    {
        if( !is_string( $mimeType ) || !is_string( $text ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $this->size = strlen( $text );
        $this->mimeType = $mimeType;
        $this->text = $text;
    }
}
