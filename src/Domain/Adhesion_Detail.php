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
        $this->code_produit = code_produit;
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
}
