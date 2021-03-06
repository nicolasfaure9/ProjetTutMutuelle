<?php
namespace ProjetTutMutuelle\DAO;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use ProjetTutMutuelle\Domain\Beneficiaire;

class BeneficiaireDAO extends DAO implements UserProviderInterface
{
    //cherche un beneficiaire sur son id
    public function find($id) {
        $sql = "select * from beneficiaire where num=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No beneficiaire matching id " . $id);
    }
   
    //cherche et retourne tous les bénéficiaires
    public function findAll() {
        $sql = "select * from beneficiaire";
        $result = $this->getDb()->fetchAll($sql);
        
        // Converts query result to an array of domain objects
        $beneficiaires = array();
        foreach ($result as $row) {
            $beneficiaireNum = $row['NUM'];
            $beneficiaires[$beneficiaireNum] = $this->buildDomainObject($row);
        }
        return $beneficiaires;
    }
    
    //cherche la liste des bénéficiaires pour le numéro d'adhesion passé en paramètre
   public function findByAdhesion($numadhesion){
       $sql = "select * from beneficiaire where  num in (select num_beneficiaire_unique from adhesion_detail where num_adhesion_normalise=? and exercice_paiement=2012) ";
       $result = $this->getDb()->fetchAll($sql,array($numadhesion));
       $beneficiaires = array();
        foreach ($result as $row) {
            $beneficiaireNum = $row['NUM'];
            $beneficiaires[$beneficiaireNum] = $this->buildDomainObject($row);
        }
        return $beneficiaires;
      
       
    }
    
    //sauvegarde le nouveau mot de passe
    public function save($beneficiaire) {
        
        $beneficiaireData = array(
            'num' => $beneficiaire->getNum(),
            'sexe' => $beneficiaire->getSexe(),
            'usr_password' => $beneficiaire->getPassword(),
            );
        if ($beneficiaire->getNum()) {
            // The beneficiaire has already been saved : update it
            $this->getDb()->update('beneficiaire', $beneficiaireData, array('num' => $beneficiaire->getNum()));
        } else {
            
        }
    }
    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from beneficiaire where usr_name=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('Beneficiaire "%s" not found.', $username));
    }
    /**
     * {@inheritDocb
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }
    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'ProjetTutMutuelle\Domain\Beneficiaire' === $class;
    }
    
    protected function buildDomainObject($row) {
        $beneficiaire = new Beneficiaire();
        $beneficiaire->setNum($row['NUM']);
        $beneficiaire->setSexe($row['SEXE']);
        $beneficiaire->setDateNaissance($row['DATE_NAISSANCE_BENEFICIAIRE']);
        $beneficiaire->setPassword($row['USR_PASSWORD']);
        $beneficiaire->setSalt($row['USR_SALT']);
        $beneficiaire->setRole($row['USR_ROLE']);
        $beneficiaire->setUsername($row['USR_NAME']);
        $beneficiaire->setRegime_Social($row['REGIME_SOCIAL']);
        $beneficiaire->setPrenom($row['PRENOM']);
        return $beneficiaire;
    }
}