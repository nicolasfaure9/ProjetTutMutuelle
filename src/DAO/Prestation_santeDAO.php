<?php

namespace ProjetTutMutuelle\DAO;

use ProjetTutMutuelle\Domain\Prestation_sante;

class Prestation_santeDAO extends DAO {

    
   
    public function findAll() {
        $sql = "select * from prestation_sante";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $prestations_sante = array();
        foreach ($result as $row) {
            $prestations_santeId = $row['NUM_SINISTRE'];
            $prestations_sante[$prestations_santeId] = $this->buildDomainObject($row);
        }
        return $prestations_sante;
    }

   
 public function setAdhesion_DetailDAO($Adhesion_DetailDAO) {
        $this->Adhesion_DetailDAO = $Adhesion_DetailDAO;
    }
    
    
    
    public function findByAdhesion($numadhesion){
       $sql = "select * from prestations_sante where num_adhesion=?  ";
       $result = $this->getDb()->fetchAll($sql,array($numadhesion));
       $prestations_santes = array();
        foreach ($result as $row) {
            $sinistreNum = $row['NUM_SINISTRE'];
            $prestations_santes[$sinistreNum] = $this->buildDomainObject($row);
        }
        return $prestations_santes;
    }
    
    public function findByAdhesionBeneficiaire($numadhesion, $numbeneficiaire){
       $sql = "select * from prestations_sante where num_adhesion=? and num_beneficiaire_sinistre=? ";
       $result = $this->getDb()->fetchAll($sql,array($numadhesion, $numbeneficiaire));
       $prestations_santes = array();
        foreach ($result as $row) {
            $sinistreNum = $row['NUM_SINISTRE'];
            $prestations_santes[$sinistreNum] = $this->buildDomainObject($row);
        }
        return $prestations_santes;
    }
    
    protected function buildDomainObject($row) {    
        
        $prestation_sante = new Prestation_Sante();
        $prestation_sante->setNum_sinistre($row['NUM_SINISTRE']);
        $prestation_sante->setNum_adhesion($row['NUM_ADHESION']);
        $prestation_sante->setNum_benificiaire_sinistre($row['NUM_BENEFICIAIRE_SINISTRE']);
        $prestation_sante->setNum_beneficiaire($row['NUM_BENEFICIAIRE']);
        $prestation_sante->setActe($row['ACTE']);
        $prestation_sante->setDesignation_acte($row['DESIGNATION_ACTE']);
        $prestation_sante->setLibelle_bareme($row['LIBELLE_BAREME']);
        $prestation_sante->setJour_debut_soins($row['JOUR_DEBUT_SOINS']);
        $prestation_sante->setMois_debut_soins($row['MOIS_DEBUT_SOINS']);
        $prestation_sante->setAnnee_debut_soins($row['ANNEE_DEBUT_SOINS']);
        $prestation_sante->setJour_paiement($row['JOUR_PAIEMENT']);
        $prestation_sante->setMois_paiement($row['MOIS_PAIEMENT']);
        $prestation_sante->setAnnee_paiement($row['ANNEE_PAIEMENT']);
        $prestation_sante->setFrais_reel_assure($row['FRAIS_REEL_ASSURE']);
        $prestation_sante->setMontant_secu($row['MONTANT_SECU']);
        $prestation_sante->setMontant_rembourse($row['MONTANT_REMBOURSE']);
        
        return $prestation_sante;
    }

}

