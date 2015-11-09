<?php

namespace ProjetTutMutuelle\DAO;

use ProjetTutMutuelle\Domain\Departements;

class DepartementsDAO extends DAO {

    
   

    /**
     * Returns the list of all regions, 
     * @return array The list of all regions.
     */
    public function findAll() {
        $sql = "select * from departements";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $departements = array();
        foreach ($result as $row) {
            $departementsId = $row['NUM_DEPARTEMENT'];
            $departements[$departementsId] = $this->buildDomainObject($row);
        }
        return $departements;
    }

   

    
    protected function buildDomainObject($row) {
        

        $departement = new Departement();
        $departement->setNum($row['NUM_DEPARTEMENT']);
        $departement->setNumRegion($row['NUM_REGION']);
        $departement->setLib($row['LIB_DEPARTEMENT']);
        
        return $departement;
    }

}

