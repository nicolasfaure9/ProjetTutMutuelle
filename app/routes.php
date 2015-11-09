<?php

//changer GSB 

use Symfony\Component\HttpFoundation\Request;


// Home page
$app->get('/', "ProjetTutMutuelle\Controller\BeneficiaireController::beneficiaireAction");
$app->get('/accueil', "ProjetTutMutuelle\Controller\AccueilController::accueilAction");

$app->get('/login', "ProjetTutMutuelle\Controller\HomeController::loginAction")->bind('login');  // named route so that path('login') works in Twig templates

