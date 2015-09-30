<?php


namespace ProjetTutMutuelle\Domain;

/**
 * Description of Departements
 *
 * @author p1511080
 */
class Departements {
    private $num;

    private $num_region;
    
    private $lib;

    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
    }

    public function getNum_Region() {
        return $this->num_region;
    }

    public function setNum_Region($num_region) {
        $this->num_region = $num_region;
    }
    public function getLib() {
        return $this->lib;
    }

    public function setLib($lib) {
        $this->lib = $lib;
    }
}
