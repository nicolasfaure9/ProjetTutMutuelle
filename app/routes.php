<?php



use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

// Home page
$app->get('/', "ProjetTutMutuelle\Controller\BeneficiaireController::beneficiaireAction");
$app->get('/accueil', "ProjetTutMutuelle\Controller\AccueilController::accueilAction");
$app->get('/remboursements', "ProjetTutMutuelle\Controller\RemboursementsController::remboursementsAction");
$app->get('/beneficiaires', "ProjetTutMutuelle\Controller\BeneficiairesController::beneficiairesAction");
$app->get('/contrats', "ProjetTutMutuelle\Controller\ContratsController::contratsAction");
$app->get('/newContract', "ProjetTutMutuelle\Controller\NewContratController::newContratAction");
$app->get('/detailContrat', "ProjetTutMutuelle\Controller\DetailContratController::detailContratAction");
$app->get('/profil', "ProjetTutMutuelle\Controller\ProfilController::profilAction");
$app->get('/contacts', "ProjetTutMutuelle\Controller\ContactsController::contactsAction");
$app->get('/documents', "ProjetTutMutuelle\Controller\DocumentsController::documentsAction");

$app->get('/login', "ProjetTutMutuelle\Controller\HomeController::loginAction")->bind('login');  // named route so that path('login') works in Twig templates

$app->match('/me', "ProjetTutMutuelle\Controller\BeneficiaireController::profileAction");


$app->get('/test', "ProjetTutMutuelle\Controller\adhesionDetailController::adhesionDetailAction");
