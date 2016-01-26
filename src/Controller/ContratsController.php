<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class ContratsController {

//Chercher tous les beneficiaires et renvoie sur la page contrat
 public function contratsAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('contrats.html.twig', array('beneficiaires' => $beneficiaires));
    }
    
}
 
