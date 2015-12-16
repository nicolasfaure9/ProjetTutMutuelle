<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class ProfilController {

 public function profilAction(Application $app) {
        $adherent = $app['dao.adhesion']->findByBeneficiaireAndYear($app['security']->getToken()->getUser()->getNum());
        return $app['twig']->render('profil.html.twig', array('adherent' => $adherent));
    }

}
 
