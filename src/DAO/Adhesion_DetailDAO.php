<?php

namespace ProjetTutMutuelle\DAO;

use ProjetTutMutuelle\Domain\Adhesion_Detail;

class Adhesion_DetailDAO extends DAO {

    
  
    public function findAll() {
        $sql = "select * from adhesion_detail";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $adhesion_details = array();
        foreach ($result as $row) {
            $adhesion_detailsId = $row['NUM_ADHESION_NORMALISE'];
            $adhesion_details[$adhesion_detailsId] = $this->buildDomainObject($row);
        }
        return $adhesion_details;
    }

   

    
    protected function buildDomainObject($row) {
        

        $adhesion_detail = new Adhesion_Detail();
        $adhesion_detail->setNum($row['NUM_ADHESION_NORMALISE']);
        $adhesion_detail->setNumBenificiaireUnique($row['NUM_BENEFICIAIRE_UNIQUE']);
        $adhesion_detail->setCodeProfession($row['CODE_PROFESSION']);
        $adhesion_detail->setCodeProduit($row['CODE_PRODUIT']);
        $adhesion_detail->setCodeFractionnement($row['CODE_FRACTIONNEMENT']);
        $adhesion_detail->setCodeGarantie($row['CODE_GARANTIE']);
        $adhesion_detail->setFormule($row['FORMULE']);
        $adhesion_detail->setExercicePaiement($row['EXERCICE_PAIEMENT']);
        $adhesion_detail->setNumBeneficiaire($row['NUM_BENEFICIAIRE']);
        $adhesion_detail->setTypeBeneficiaire($row['TYPE_BENEFICIAIRE']);
        $adhesion_detail->setPrimes_acquises($row['PRIMES_ACQUISES']);
        $adhesion_detail->setCode_agent($row['CODE_AGENT']);
        $adhesion_detail->setCode_region($row['CODE_REGION']);
        $adhesion_detail->setPrime_garantie($row['PRIME_GARANTIE']);
        $adhesion_detail->setCode_postal($row['CODE_POSTAL']);
        
        return $adhesion_detail;
    }

}

