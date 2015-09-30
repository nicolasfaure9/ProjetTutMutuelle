<?php

//changer GSB 

use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Domain\VisitReport;
use ProjetTutMutuelle\Form\Type\VisitorType;
use ProjetTutMutuelle\Form\Type\VisitReportType;


// Home page
$app->get('/', "ProjetTutMutuelle\Controller\RegionController::regionAction");
