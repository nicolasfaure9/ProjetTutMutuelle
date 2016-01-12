<?php
namespace ProjetTutMutuelle\Domain;
/**
 * Description of Benficiaires
 *
 * @author p1511080
 */
use Symfony\Component\Security\Core\User\UserInterface;
class Beneficiaire implements UserInterface{
    
    private $num;
    
    private $sexe;
    
    private $regime_social;
    
    private $date_naissance;
    
    private $password;
    
    
    private $username;
    
    
    private $salt;

    private $role;
    
    public function getPassword() {
        return $this->password;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getRole() {
        return $this->role;
    }
 public function getRoles()
    {
        return array($this->getRole());
    }
    public function setPassword($password) {
        $this->password = $password;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
            $this->username = $username;
        }

      
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
    
    public function eraseCredentials() {
        
    }
}
