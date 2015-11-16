<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class NewContractController {

 public function newContractAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('newContract.html.twig', array('beneficiaires' => $beneficiaires));
    }
    
}
 
