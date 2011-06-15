<?php

namespace Insomnia\Validator;

class ErrorStack extends \Exception
{
    private $errors;
    
    public function __construct( $errors )
    {
        $this->setErrors( $errors );
    }
    
    public function getErrors() {
        return $this->errors;
    }

    public function setErrors($errors) {
        $this->errors = $errors;
    }
}