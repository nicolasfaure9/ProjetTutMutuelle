<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class BeneficiaireController {

   //va chercher tous les bénéficiaires et retourne la page d'accueil 
 public function beneficiaireAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('accueil.html.twig', array('beneficiaires' => $beneficiaires));
    }
    
    //Crée un formulaire pour que l'utilisateur puisse changer le mot de passe 
    public function profileAction(Request $request, Application $app) {
        $beneficiaire = $app['security']->getToken()->getUser();
        $beneficiaireForm = $app['form.factory']->create(new BeneficiaireType(), $beneficiaire);
        $beneficiaireForm->handleRequest($request);
        if ($beneficiaireForm->isValid()) {
            $plainPassword = $beneficiaire->getPassword();
            $encoder = $app['security.encoder_factory']->getEncoder($beneficiaire);
            // Crypte le code
            $password = $encoder->encodePassword($plainPassword, $beneficiaire->getSalt());
            $beneficiaire->setPassword($password); 
            $app['dao.beneficiaire']->save($beneficiaire);
            $app['session']->getFlashBag()->add('success', 'Vos informations personnelles ont été mises à jour.');
        }
       $beneficiaireFormView= $beneficiaireForm->createView();
        return $app['twig']->render('beneficiaire.html.twig', array('beneficiaireForm' => $beneficiaireFormView));
}
}
 
