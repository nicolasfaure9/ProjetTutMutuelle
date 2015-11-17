<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class ContractsController {

 public function contractsAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('contracts.html.twig', array('beneficiaires' => $beneficiaires));
    }
    
}
 
