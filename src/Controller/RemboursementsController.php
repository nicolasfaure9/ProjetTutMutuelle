<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class RemboursementsController {

 public function remboursementsAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('remboursements.html.twig', array('beneficiaires' => $beneficiaires));
    }

}
 
