<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class RegionController {

 public function regionAction(Application $app) {
        $regions = $app['dao.region']->findAll();
        return $app['twig']->render('index.html.twig', array('regions' => $regions));
    }
} 
 