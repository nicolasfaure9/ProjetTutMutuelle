<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class BeneficiaireController {

 public function beneficiaireAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('index.html.twig', array('beneficiaires' => $beneficiaires));
    }
} 
 
