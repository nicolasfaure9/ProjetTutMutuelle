<?php

//changer GSB 

use Symfony\Component\HttpFoundation\Request;
use GSB\Domain\VisitReport;
use GSB\Form\Type\VisitorType;
use GSB\Form\Type\VisitReportType;


// Home page
$app->get('/', "GSB\Controller\HomeController::indexAction");

// Details for a drug
$app->get('/drugs/{id}', "GSB\Controller\DrugController::drugDetailsAction");

// List of all drugs
$app->get('/drugs/', "GSB\Controller\DrugController::drugsAction");
