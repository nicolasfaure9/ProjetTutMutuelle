<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AccueilController {

 public function accueilAction(Application $app) {
        //$regions = $app['dao.region']->findAll();
        return $app['twig']->render('accueil.html.twig');
    }
} 

