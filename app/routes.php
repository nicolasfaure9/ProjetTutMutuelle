<?php

//changer GSB 

use Symfony\Component\HttpFoundation\Request;


// Home page
$app->get('/', "ProjetTutMutuelle\Controller\RegionController::regionAction");


