<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class PrestationSanteController {

 public function prestationSanteDetailAction(Application $app) {
     
        $adhesion = $app['dao.adhesion']->findByBeneficiaireAndYear($app['security']->getToken()->getUser()->getNum());
        $prestations_Santes = $app['dao.prestationSante']->findByAdhesion($adhesion->getNum());
        $adhesion->setPrestations_Details($prestations_Santes);
        return $app['twig']->render('remboursements.html.twig', array('adhesion' => $adhesion));
    }
    
    public function prestationSanteDetailActionBeneficiaire($id, Application $app) {
     
        $adhesion = $app['dao.adhesion']->findByBeneficiaireAndYear($app['security']->getToken()->getUser()->getNum());
        $prestations_Santes = $app['dao.prestationSante']->findByAdhesionBeneficiaire($adhesion->getNum(),$id);
        $adhesion->setPrestations_Details($prestations_Santes);
        return $app['twig']->render('remboursements.html.twig', array('adhesion' => $adhesion));
    }
    
    public function prestationSanteDetailActionLimit( Application $app) {
     
        $adhesion = $app['dao.adhesion']->findByBeneficiaireAndYear($app['security']->getToken()->getUser()->getNum());
        $prestations_Santes = $app['dao.prestationSante']->findByAdhesionLimit($adhesion->getNum());
        $adhesion->setPrestations_Details($prestations_Santes);
        return $app['twig']->render('accueil.html.twig', array('adhesion' => $adhesion));
    }
    
    public function prestationSanteDetailActionRemboursement($id, Application $app) {
        $prestation_Sante = $app['dao.prestationSante']->find($id);
        return $app['twig']->render('remboursement.html.twig', array('prestation_sante' => $prestation_Sante));
    }
}

 
