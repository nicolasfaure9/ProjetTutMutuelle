<?php



use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

// Home page
$app->get('/', "ProjetTutMutuelle\Controller\BeneficiaireController::beneficiaireAction");
$app->get('/accueil', "ProjetTutMutuelle\Controller\AccueilController::accueilAction");

$app->get('/login', "ProjetTutMutuelle\Controller\HomeController::loginAction")->bind('login');  // named route so that path('login') works in Twig templates

$app->match('/me', "ProjetTutMutuelle\Controller\BeneficiaireController::profileAction");
