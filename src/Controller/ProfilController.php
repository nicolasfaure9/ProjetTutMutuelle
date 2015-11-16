<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class ProfilController {

 public function profilAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('profil.html.twig', array('beneficiaires' => $beneficiaires));
    }

}
 
