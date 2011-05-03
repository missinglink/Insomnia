<?php

namespace Application\Repository;
 
use \Doctrine\ORM\EntityRepository;

class VenueRepository extends EntityRepository
{ 
    public function findById( $venueId )
    {
        $dql = 'SELECT t FROM \Application\Entities\Test t';
        $dql .= " WHERE t.id = ?1 ";

        $q = $this->getEntityManager()->createQuery( $dql );
        
        $q->setParameter( 1, $venueId );

        $venues = $q->getResult();
        
        if ( $venues )
        {
            return $venues[ 0 ];
        }
        return null;
        
        //$em->getRepository( 'Entity\Test' )
    }
}