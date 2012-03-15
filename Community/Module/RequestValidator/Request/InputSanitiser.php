<?php

namespace Community\Module\RequestValidator\Request;

/**
 * A simple class to prevent HTML injection attacks 
 */
class InputSanitiser
{
    /**
     * @var string
     */
    private $value = '';
    
    /**
     * @param string $uncleanValue
     */
    public function __construct( $uncleanValue )
    {
        $this->value = $uncleanValue;
    }
    
    /**
     * @return InputSanitiser
     */
    public function stripTags()
    {
        if ( is_array( $this->value ) )
        {
            $this->value = array_map( 'strip_tags', $this->value );
        }
        else
        {
            $this->value = strip_tags( $this->value );
        }
        
        return $this;
    }
    
    /**
     * @param string $htmlTag
     * @return InputSanitiser
     */
    public function removeTagBody( $htmlTag )
    {
        $this->value = preg_replace( '/<'.preg_quote($htmlTag).'\b[^>]*>(.*?)<\/'.preg_quote($htmlTag).'>/i', '', $this->value );
        
        return $this;
    }
    
    /**
     * @return type
     */
    public function getValue()
    {
        return $this->value;
    }
}