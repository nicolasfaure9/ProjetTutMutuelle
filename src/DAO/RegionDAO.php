<?php

namespace ProjetTutMutuelle\DAO;

use ProjetTutMutuelle\Domain\Region;

class RegionDAO extends DAO {

    
   

    /**
     * Returns the list of all regions, 
     * @return array The list of all regions.
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

   

    
    protected function buildDomainObject($row) {
        

        $region = new Region();
        $region->setId($row['NUM_REGION']);
        $region->setLib($row['LIB_REGION']);
        
        return $region;
    }

}


