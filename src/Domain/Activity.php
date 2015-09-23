<?php

namespace GSB\Domain;

class Activity 
{
    
    private $Id;
    private $date;
    private $place;
    private $theme;
    private $purpose;
    
    
    public function getId() {
        return $this->Id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getPlace() {
        return $this->place;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function getPurpose() {
        return $this->purpose;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
    }

    public function setPurpose($purpose) {
        $this->purpose = $purpose;
    }



    
}