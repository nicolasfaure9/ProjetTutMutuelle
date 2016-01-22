<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class ProfilController {

 public function profilAction(Application $app) {
        $beneficiareProfil = $app['dao.beneficiaire']->find($app['security']->getToken()->getUser()->getNum());
        $adhesion = $app['dao.adhesion']->findByBeneficiaireAndYear($app['security']->getToken()->getUser()->getNum());
        $beneficiaires = $app['dao.beneficiaire']->findByAdhesion($adhesion->getNum());
        $prestations_Santes = $app['dao.prestationSante']->findByAdhesionBeneficiaire($adhesion->getNum(),$app['security']->getToken()->getUser()->getNum());
        $adhesion->setPrestations_Details($prestations_Santes);
        if ($adhesion->getNumBeneficiaire()==1){
            $adhesion->setBeneficiaires($beneficiaires);
            return $app['twig']->render('profil.html.twig', array('adhesion' => $adhesion, 'beneficiaireProfil'=>$beneficiareProfil));
        }
        else {
            return $app['twig']->render('profilB.html.twig', array('adhesion' => $adhesion, 'beneficiaireProfil'=>$beneficiareProfil));
        }
    }
    
    

}
 
