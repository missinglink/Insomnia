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
        $this->value = $this->stripTagsRecursive( $this->value );
        
        return $this;
    }
    
    private function stripTagsRecursive( $value )
    {
        if( is_array( $value ) )
        {
            $value = array_map( array( $this, __FUNCTION__ ), $value );
        }
        
        else if( is_string( $value ) )
        {
            $value = strip_tags( $value );
        }
        
        return $value;
    }
    
    /**
     * @param string $htmlTag
     * @return InputSanitiser
     */
    public function removeTagBody( $htmlTag )
    {
        if( is_string( $this->value ) )
        {
            $this->value = preg_replace( '/<'.preg_quote($htmlTag).'\b[^>]*>(.*?)<\/'.preg_quote($htmlTag).'>/i', '', $this->value );
        }
        
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