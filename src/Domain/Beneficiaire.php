<?php
namespace ProjetTutMutuelle\Domain;
/**
 * Description of Benficiaires
 *
 * @author p1511080
 */
class Beneficiaire {
    private $num;
    
    private $sexe;
    
    private $regime_social;
    
    private $date_naissance;
    
    public function getNum() {
        return $this->num;
    }
    public function setNum($num) {
        $this->num = $num;
    }
    public function getSexe() {
        return $this->sexe;
    }
    public function setSexe($sexe) {
        $this->sexe = $sexe;
    }
    public function getRegime_Social() {
        return $this->regime_social;
    }
    public function setRegime_Social($regime_social) {
        $this->regime_social = $regime_social;
    }
    public function getDateNaissance() {
        return $this->date_naissance;
    }
    public function setDateNaissance($date_naissance) {
        $this->date_naissance = $date_naissance;
    }
}
