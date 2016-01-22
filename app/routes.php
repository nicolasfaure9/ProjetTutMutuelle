<?php



use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

// Home page
$app->get('/', "ProjetTutMutuelle\Controller\PrestationSanteController::prestationSanteDetailActionLimit");
$app->get('/accueil', "ProjetTutMutuelle\Controller\PrestationSanteController::prestationSanteDetailActionLimit");

$app->get('/remboursements', "ProjetTutMutuelle\Controller\RemboursementsController::remboursementsAction");

$app->get('/contrats', "ProjetTutMutuelle\Controller\ContratsController::contratsAction");
$app->get('/newContract', "ProjetTutMutuelle\Controller\NewContratController::newContratAction");
$app->get('/detailContrat', "ProjetTutMutuelle\Controller\DetailContratController::detailContratAction");

$app->get('/contacts', "ProjetTutMutuelle\Controller\ContactsController::contactsAction");
$app->get('/documents', "ProjetTutMutuelle\Controller\DocumentsController::documentsAction");

$app->get('/login', "ProjetTutMutuelle\Controller\HomeController::loginAction")->bind('login');  // named route so that path('login') works in Twig templates

$app->match('/me', "ProjetTutMutuelle\Controller\BeneficiaireController::profileAction");


$app->get('/beneficiaires', "ProjetTutMutuelle\Controller\adhesionDetailController::adhesionDetailAction");


$app->get('/factures', "ProjetTutMutuelle\Controller\PrestationSanteController::prestationSanteDetailAction");
$app->get('/remboursements', "ProjetTutMutuelle\Controller\PrestationSanteController::prestationSanteDetailAction");
$app->get('/remboursements/{id}', "ProjetTutMutuelle\Controller\PrestationSanteController::prestationSanteDetailActionBeneficiaire");

$app->get('/remboursement/{id}', "ProjetTutMutuelle\Controller\PrestationSanteController::prestationSanteDetailActionRemboursement");

$app->post('/cts', "ProjetTutMutuelle\Controller\ContactsController::contactsAction");

$app->get('/profil', "ProjetTutMutuelle\Controller\ProfilController::profilAction");
$app->get('/profil/{id}', "ProjetTutMutuelle\Controller\ProfilController::profilActionBeneficiaire");


