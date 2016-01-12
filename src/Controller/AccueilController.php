<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AccueilController {

 public function accueilAction(Application $app) {
      //  $beneficiares = $app['dao.beneficiaire']->findAll();
      
        return $app['twig']->render('accueil.html.twig');
        
    }
} 

