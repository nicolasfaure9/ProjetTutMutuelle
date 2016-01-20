<?php

namespace ProjetTutMutuelle\Domain;

/**
 * Description of Prestation_sante
 *
 * @author p1511080
 */
class Prestation_sante {
    
    private $num_sinistre;
    
    private $num_adhesion;
    
    private $num_beneficiaire_sinistre;
    
    private $num_beneficiaire;
    
    private $acte;
    
    private $designation_acte;
    
    private $libelle_bareme;
    
    private $jour_debut_soins;
    
    private $mois_debut_soins;
    
    private $annee_debut_soins;
    
    private $jour_paiement;
    
    private $mois_paiement;
    
    private $annee_paiement;
    
    private $frais_reel_assure;
    
    private $montant_secu;
    
    private $montant_rembourse;
    
    private $date_soins;
    
    private $date_paiement;
    
    private $beneficiaire;
    
    
    public function getBeneficiaire() {
        return $this->beneficiaire;
    }

    public function setBeneficiaire($beneficiaire) {
        $this->beneficiaire = $beneficiaire;
    }

        
    
    public function getDate_soins() {
        return $this->date_soins;
    }

    public function getDate_paiement() {
        return $this->date_paiement;
    }

    public function setDate_soins($date_soins) {
        $this->date_soins = $date_soins;
    }

    public function setDate_paiement($date_paiement) {
        $this->date_paiement = $date_paiement;
    }

        public function getAdhesion() {
        return $this->adhesion;
    }

    public function setAdhesion($adhesion) {
        $this->adhesion = $adhesion;
    }

        public function getNum_sinistre() {
        return $this->num_sinistre;
    }

    public function getNum_adhesion() {
        return $this->num_adhesion;
    }

    public function getNum_beneficiaire_sinistre() {
        return $this->num_beneficiaire_sinistre;
    }

    public function getNum_beneficiaire() {
        return $this->num_beneficiaire;
    }

    public function getActe() {
        return $this->acte;
    }

    public function getDesignation_acte() {
        return $this->designation_acte;
    }

    public function getLibelle_bareme() {
        return $this->libelle_bareme;
    }

    public function getJour_debut_soins() {
        return $this->jour_debut_soins;
    }

    public function getMois_debut_soins() {
        return $this->mois_debut_soins;
    }

    public function getAnnee_debut_soins() {
        return $this->annee_debut_soins;
    }

    public function getJour_paiement() {
        return $this->jour_paiement;
    }

    public function getMois_paiement() {
        return $this->mois_paiement;
    }

    public function getAnnee_paiement() {
        return $this->annee_paiement;
    }

    public function getFrais_reel_assure() {
        return $this->frais_reel_assure;
    }

    public function getMontant_secu() {
        return $this->montant_secu;
    }

    public function getMontant_rembourse() {
        return $this->montant_rembourse;
    }

    public function setNum_sinistre($num_sinistre) {
        $this->num_sinistre = $num_sinistre;
    }

    public function setNum_adhesion($num_adhesion) {
        $this->num_adhesion = $num_adhesion;
    }

    public function setNum_beneficiaire_sinistre($num_beneficiaire_sinistre) {
        $this->num_beneficiaire_sinistre = $num_beneficiaire_sinistre;
    }

    public function setNum_beneficiaire($num_beneficiaire) {
        $this->num_beneficiaire = $num_beneficiaire;
    }

    public function setActe($acte) {
        $this->acte = $acte;
    }

    public function setDesignation_acte($designation_acte) {
        $this->designation_acte = $designation_acte;
    }

    public function setLibelle_bareme($libelle_bareme) {
        $this->libelle_bareme = $libelle_bareme;
    }

    public function setJour_debut_soins($jour_debut_soins) {
        $this->jour_debut_soins = $jour_debut_soins;
    }

    public function setMois_debut_soins($mois_debut_soins) {
        $this->mois_debut_soins = $mois_debut_soins;
    }

    public function setAnnee_debut_soins($annee_debut_soins) {
        $this->annee_debut_soins = $annee_debut_soins;
    }

    public function setJour_paiement($jour_paiement) {
        $this->jour_paiement = $jour_paiement;
    }

    public function setMois_paiement($mois_paiement) {
        $this->mois_paiement = $mois_paiement;
    }

    public function setAnnee_paiement($annee_paiement) {
        $this->annee_paiement = $annee_paiement;
    }

    public function setFrais_reel_assure($frais_reel_assure) {
        $this->frais_reel_assure = $frais_reel_assure;
    }

    public function setMontant_secu($montant_secu) {
        $this->montant_secu = $montant_secu;
    }

    public function setMontant_rembourse($montant_rembourse) {
        $this->montant_rembourse = $montant_rembourse;
    }

    
}
