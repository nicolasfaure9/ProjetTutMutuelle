<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class DetailContratController {

 //Chercher tous les beneficiaires et renvoie sur la page contrat
 public function detailContratAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('detailContrat.html.twig', array('beneficiaires' => $beneficiaires));
    }
    

}
 
