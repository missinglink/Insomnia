<?php

namespace Insomnia\Controller;

interface RestControllerInterface
{
    public function create();
    public function read( $id );
    public function update( $id );
    public function delete( $id );
    public function index();
}