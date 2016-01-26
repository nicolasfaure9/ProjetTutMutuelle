<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class adhesionDetailController {

 //aller chercher les beneficiaires de l'adhesion pour l'utilisateur connecté et retourne la page beneficiaires.html   
 public function adhesionDetailAction(Application $app) {
        $adhesion = $app['dao.adhesion']->findByBeneficiaireAndYear($app['security']->getToken()->getUser()->getNum());
        $beneficiaires = $app['dao.beneficiaire']->findByAdhesion($adhesion->getNum());
        $adhesion->setBeneficiaires($beneficiaires);
        return $app['twig']->render('beneficiaires.html.twig', array('adhesion' => $adhesion));
    }
    
    
}

 
