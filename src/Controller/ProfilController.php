<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class ProfilController {

//aller chercher toutes les infos liées a l'utilisateur connecté    
 public function profilAction(Application $app) {
        $beneficiareProfil = $app['dao.beneficiaire']->find($app['security']->getToken()->getUser()->getNum());
        $adhesion = $app['dao.adhesion']->findByBeneficiaireAndYear($app['security']->getToken()->getUser()->getNum());
        $beneficiaires = $app['dao.beneficiaire']->findByAdhesion($adhesion->getNum());
        $prestations_Santes = $app['dao.prestationSante']->findByAdhesionBeneficiaire($adhesion->getNum(),$app['security']->getToken()->getUser()->getNum());
        $adhesion->setPrestations_Details($prestations_Santes);
        $adhesion->setBeneficiaires($beneficiaires);
        return $app['twig']->render('profil.html.twig', array('adhesion' => $adhesion, 'beneficiaireProfil'=>$beneficiareProfil));
        
    }
  //aller chercher toutes les infos liées a l'id de l'utilisateur passé en paramètre connecté     
 public function profilActionBeneficiaire($id, Application $app) {
        $beneficiareProfil = $app['dao.beneficiaire']->find($id);
        $adhesion = $app['dao.adhesion']->findByBeneficiaireAndYear($id);
        $prestations_Santes = $app['dao.prestationSante']->findByAdhesionBeneficiaire($adhesion->getNum(),$id);
        $adhesion->setPrestations_Details($prestations_Santes);
        $beneficiaires = $app['dao.beneficiaire']->findByAdhesion($adhesion->getNum());
        $adhesion->setBeneficiaires($beneficiaires);
        return $app['twig']->render('profil.html.twig', array('adhesion' => $adhesion, 'beneficiaireProfil'=>$beneficiareProfil));

    }
    

}
