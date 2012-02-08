<?php

namespace Insomnia\Pattern;

use \Insomnia\Response;

interface Mapper
{
    public function map( Response $response );
}