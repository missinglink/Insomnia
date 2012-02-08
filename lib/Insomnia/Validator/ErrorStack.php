<?php

namespace Insomnia\Validator;

class ErrorStack extends \Exception
{
    private $errors;
    
    public function __construct( $errors )
    {
        parent::__construct( 'ErrorStack', 400 );
        $this->setErrors( $errors );
    }
    
    public function getErrors() {
        return $this->errors;
    }

    public function setErrors( $errors )
    {
        $this->errors = $errors;
    }
}