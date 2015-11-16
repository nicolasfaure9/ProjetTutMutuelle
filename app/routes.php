<?php



use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

// Home page
$app->get('/', "ProjetTutMutuelle\Controller\BeneficiaireController::beneficiaireAction");
$app->get('/accueil', "ProjetTutMutuelle\Controller\AccueilController::accueilAction");
$app->get('/remboursements', "ProjetTutMutuelle\Controller\RemboursementsController::remboursementsAction");
$app->get('/beneficiaires', "ProjetTutMutuelle\Controller\BeneficiairesController::beneficiairesAction");
$app->get('/contracts', "ProjetTutMutuelle\Controller\ContractsController::contractsAction");
$app->get('/newContract', "ProjetTutMutuelle\Controller\NewContractController::newContractAction");
$app->get('/detailContract', "ProjetTutMutuelle\Controller\DetailContractController::detailContractAction");
$app->get('/profil', "ProjetTutMutuelle\Controller\ProfilController::detailContractAction");
$app->get('/contacts', "ProjetTutMutuelle\Controller\ContactsController::detailContractAction");
$app->get('/documents', "ProjetTutMutuelle\Controller\DocumentsController::detailContractAction");

$app->get('/login', "ProjetTutMutuelle\Controller\HomeController::loginAction")->bind('login');  // named route so that path('login') works in Twig templates

$app->match('/me', "ProjetTutMutuelle\Controller\BeneficiaireController::profileAction");
