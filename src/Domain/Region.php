<?php

namespace ProjetTutMutuelle\Domain;

class Region 
{
    /**
     * Drug id.
     *
     * @var integer
     */
    private $id;

   
    private $lib;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }


    public function getLib() {
        return $this->lib;
    }

    public function setLib($lib) {
        $this->lib = $lib;
    }
}