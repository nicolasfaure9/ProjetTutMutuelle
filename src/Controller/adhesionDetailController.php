<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class adhesionDetailController {

 public function adhesionDetailAction(Application $app) {
        $adhesion = $app['dao.adhesion']->findByBeneficiaireAndYear($app['security']->getToken()->getUser()->getNum());
        $beneficiaires = $app['dao.beneficiaire']->findByAdhesion($adhesion->getNum());
     
        $adhesion->setBeneficiaires($beneficiaires);
        
        return $app['twig']->render('test.html.twig', array('adhesion' => $adhesion));
    }
    
    
}

 
