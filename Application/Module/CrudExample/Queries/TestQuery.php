<?php

namespace Application\Module\CrudExample\Queries;

use \Doctrine\ORM\QueryBuilder,
    \Doctrine\ORM\EntityManager,
    \DoctrineExtensions\Paginate\PaginationAdapter;

class TestQuery extends QueryBuilder
{
    public function __construct( EntityManager $em )
    {
        parent::__construct( $em );

        $this->select('t');
        $this->from( 'Application\Module\CrudExample\Entities\Test', 't' );
    }
}