<?php

namespace ProjetTutMutuelle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetTutMutuelle\Form\Type\BeneficiaireType;

class BeneficiaireController {

 public function beneficiaireAction(Application $app) {
        $beneficiaires = $app['dao.beneficiaire']->findAll();
        return $app['twig']->render('index.html.twig', array('beneficiaires' => $beneficiaires));
    }
    
    public function profileAction(Request $request, Application $app) {
        $beneficiaire = $app['security']->getToken()->getUser();
       
        $beneficiaireForm = $app['form.factory']->create(new BeneficiaireType(), $beneficiaire);
        $beneficiaireForm->handleRequest($request);
        if ($beneficiaireForm->isValid()) {
            $plainPassword = $beneficiaire->getPassword();
            // find the encoder for a UserInterface instance
            $encoder = $app['security.encoder_factory']->getEncoder($beneficiaire);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $beneficiaire->getSalt());
            $beneficiaire->setPassword($password); 
            $app['dao.beneficiaire']->save($beneficiaire);
            $app['session']->getFlashBag()->add('success', 'Vos informations personnelles ont été mises à jour.');
        }
       $beneficiaireFormView= $beneficiaireForm->createView();
        return $app['twig']->render('beneficiaire.html.twig', array('beneficiaireForm' => $beneficiaireFormView));
}
}
 
