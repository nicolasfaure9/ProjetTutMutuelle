<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class DocumentsController {

 //Chercher tous les beneficiaires et renvoie sur la page contrat
 public function documentsAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('documents.html.twig', array('beneficiaires' => $beneficiaires));
    }

}
 
