<?php

namespace Application\Controller\Openshuffle;

use \Application\Bootstrap\Doctrine,
    \Insomnia\Controller\Action,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Request\Validator\EmailValidator,
    \Application\Entities\Player,
    \Application\Modifier\Layout;

use \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator;

class CreateAction extends Action
{
    private $requestValidator;
    
    public function __construct()
    {
        parent::__construct();
        $this->response->setContentType( 'application/json' );
        $this->getResponse()->addModifier( new Layout );
    }
    
    public function validate()
    {
        $this->requestValidator = new RequestValidator;
        $this->requestValidator->required( 'name',     new StringValidator( 4, 255 ) );
        $this->requestValidator->required( 'password', new StringValidator( 4, 255 ) );
        $this->requestValidator->required( 'email',    new EmailValidator );
        $this->requestValidator->validate();
    }

    public function action()
    {       
        $doctrine = new Doctrine;

        $player = new Player();
        $player->fromArray( $this->requestValidator->getParams() );
        $player->validate();
        
        $doctrine->getManager()->persist( $player );
        $doctrine->getManager()->flush();

        $this->response->push( $player->toArray() );
    }
}