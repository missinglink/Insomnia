<?php

namespace Insomnia\Kernel\Module\RequestValidator\Request\Validator;

use \Insomnia\Request,
    \Insomnia\Kernel\Module\RequestValidator\Request\ValidatorException;

class StringValidator extends RegexValidator
{
    private $min, $max;
    
    public function __construct( $min = 1, $max = null )
    {
        $this->min = $min;
        $this->max = $max;
        
        $chars = ( null !== $max && $min > 1 ) ? '{'.$min.','.$max.'}' : '';
        $this->pattern = '%^(.+)'.$chars.'$%';
    }
    
    public function validate( $string, $key )
    {
        try{ parent::validate( $string, $key ); }
        
        catch( ValidatorException $e )
        {
            throw new ValidatorException( ( null !== $this->max && $this->min > 1 ) ? 'length' : 'string' );
        }
    }
}