<?php

namespace ProjetTutMutuelle\Domain;

/**
 * Description of Adhesion_Detail
 *
 * @author p1511080
 */
class Adhesion_Detail {
    private $num;
    
    private $num_benificiaire_unique;
    
    private $code_profession;
    
    private $code_produit;
    
    private $code_fractionnement;
    
    private $code_garantie;
    
    private $formule;
    
    private $exercice_paiement;
    
    private $num_beneficiaire;
    
    private $type_beneficiaire;
    
    private $primes_acquises;
    
    private $code_agent;
    
    private $code_region;
    
    private $prime_garantie;
    
    private $code_postal;
    
    private $beneficiaires;
    
    private $prestations_Details;
    
    
    public function getPrestations_Details() {
        return $this->prestations_Details;
    }

    public function setPrestations_Details($prestations_Details) {
        $this->prestations_Details = $prestations_Details;
    }

        public function getBeneficiaires() {
        return $this->beneficiaires;
    }

    public function setBeneficiaires($beneficiaires) {
        $this->beneficiaires = $beneficiaires;
    }

        public function getPrimes_acquises() {
        return $this->primes_acquises;
    }

    public function getCode_agent() {
        return $this->code_agent;
    }

    public function getCode_region() {
        return $this->code_region;
    }

    public function getPrime_garantie() {
        return $this->prime_garantie;
    }

    public function getCode_postal() {
        return $this->code_postal;
    }

    public function setPrimes_acquises($primes_acquises) {
        $this->primes_acquises = $primes_acquises;
    }

    public function setCode_agent($code_agent) {
        $this->code_agent = $code_agent;
    }

    public function setCode_region($code_region) {
        $this->code_region = $code_region;
    }

    public function setPrime_garantie($prime_garantie) {
        $this->prime_garantie = $prime_garantie;
    }

    public function setCode_postal($code_postal) {
        $this->code_postal = $code_postal;
    }

        public function getNum() {
        return $this->num;
    }
    public function setNum($num) {
        $this->num = $num;
    }
        
    public function getNumBenificiaireUnique() {
        return $this->num_beneficiaire_unique;
    }
    public function setNumBenificiaireUnique($num_benificiaire_unique) {
        $this->num_benificiaire_unique = $num_benificiaire_unique;    
    
    }
    public function getCodeProfession() {
        return $this->code_profession;
    }
    public function setCodeProfession($code_profession) {
        $this->code_profession = $code_profession;
    }
    
    public function getCodeProduit() {
        return $this->code_produit;
    }
    public function setCodeProduit($code_produit) {
        $this->code_produit = $code_produit;
    }
    
    public function getCodeFractionnement() {
        return $this->code_fractionnement;
    }
    public function setCodeFractionnement($code_fractionnement) {
        $this->code_fractionnement = $code_fractionnement;
    }
    
    public function getCodeGarantie() {
        return $this->code_garantie;
    }
    public function setCodeGarantie($code_garantie) {
        $this->code_garantie = $code_garantie;
    }
    
    public function getFormule() {
        return $this->formule;
    }
    public function setFormule($formule) {
        $this->formule = $formule;
    }
    
    public function getExercicePaiement() {
        return $this->exercice_paiement;
    }
    public function setExercicePaiement($exercice_paiement) {
        $this->exercice_paiement = $exercice_paiement;
    }
    
    public function getNumBeneficiaire() {
        return $this->num_beneficiaire;
    }
    public function setNumBeneficiaire($num_beneficiaire) {
        $this->num_beneficiaire = $num_beneficiaire;
    }
        
    public function getTypeBeneficiaire() {
        return $this->type_beneficiaire;
    }
    public function setTypeBeneficiaire($type_beneficiaire) {
        $this->type_beneficiaire = $type_beneficiaire;
    }
}
