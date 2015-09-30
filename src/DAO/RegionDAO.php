<?php

namespace ProjetTutMutuelle\DAO;

use ProjetTutMutuelle\Domain\Region;

class RegionDAO extends DAO {

    /**
     * @var \GSB\DAO\PractitionerTypeDAO
     */
    

   

    /**
     * Returns the list of all practitioners, sorted by name and first name.
     *
     * @return array The list of all practitioners.
     */
    public function findAll() {
        $sql = "select * from BDRENS.regions";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $regions = array();
        foreach ($result as $row) {
            $regionId = $row['NUM_REGION'];
            $regions[$regionId] = $this->buildDomainObject($row);
        }
        return $regions;
    }

   

    /**
     * Creates a Practitioner instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\Practitioner
     */
    protected function buildDomainObject($row) {
        

        $region = new Region();
        $region->setId($row['NUM_REGION']);
        $region->setLib($row['LIB_REGION']);
        
        return $region;
    }

}


