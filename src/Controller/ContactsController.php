<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class ContactsController {

 public function contactsAction(Application $app) {
  
    mail("nicolas.faure69@hotmail.fr","My subject","un message");

        return $app['twig']->render('contacts.html.twig');
    }

    
    
}
 
