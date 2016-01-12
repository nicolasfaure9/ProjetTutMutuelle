<?php

namespace ProjetTutMutuelle\DAO;

use ProjetTutMutuelle\Domain\Adhesion_Detail;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;
class Adhesion_DetailDAO extends DAO {

    private $BeneficiaireDAO;

    public function setBeneficiaireDAO($BeneficiaireDAO) {
        $this->BeneficiareDAO = $BeneficiaireDAO;
    }
  
   

   public function findByBeneficiaireAndYear($beneficiaire){
       $sql = "select * from adhesion_detail where  num_beneficiaire_unique=? and exercice_paiement=2012 ";
       $result = $this->getDb()->fetchAssoc($sql, array($beneficiaire));
       return $this->buildDomainObject($result);
    }
   
 public function find($numAdhesion,$beneficiaire,$anneeDebutSoin){
       $sql = "select * from adhesion_detail where  and num_beneficiaire_unique=? and annee_debut_soin=? ";
       $result = $this->getDb()->fetchAssoc($sql, array($beneficiaire,$anneeDebutSoin));
        return $this->buildDomainObject($result);
    }
    
    
    
    protected function buildDomainObject($row) {
       
        $adhesion_detail = new Adhesion_Detail();       
        $adhesion_detail->setNum($row['NUM_ADHESION_NORMALISE']);
        $adhesion_detail->setNumBeneficiaireUnique($row['NUM_BENEFICIAIRE_UNIQUE']);
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

