<?php

namespace Application\Queries;

use \Doctrine\ORM\QueryBuilder,
    \Doctrine\ORM\EntityManager,
    \DoctrineExtensions\Paginate\PaginationAdapter;

class PlayerQuery extends QueryBuilder
{
    private $em;
    private $class = 'Application\Entities\Player';
    private $alias = 'p';
    
    public function __construct( EntityManager $em )
    {
        parent::__construct( $em );
        $this->em = $em;
    }

    public function findAll()
    {
        $this->select( $this->alias );
        $this->from( $this->class, $this->alias );
        return $this;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass($class) {
        $this->class = $class;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }
}