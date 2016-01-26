<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AccueilController {

 public function accueilAction(Application $app) {
      //  retourne la page d'accueil
        return $app['twig']->render('accueil.html.twig');
        
    }
    
   

}

