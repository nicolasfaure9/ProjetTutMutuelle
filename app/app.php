<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) {
            $twig->addExtension(new Twig_Extensions_Extension_Text());
            return $twig;
        }));
 //Register security providers       
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array(
            'pattern' => '^/login$',
            'anonymous' => true
        ),
        'secured' => array(
            'pattern' => '^/',
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new ProjetTutMutuelle\DAO\BeneficiaireDAO($app['db']);
            }),
        ),
    ),
));


        $app['dao.region'] = $app->share(function ($app) {
    return new ProjetTutMutuelle\DAO\RegionDAO($app['db']);
});
    
$app['dao.beneficiaire'] = $app->share(function ($app) {
    return new ProjetTutMutuelle\DAO\BeneficiaireDAO($app['db']);
    });
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

$app['dao.adhesion'] = $app->share(function ($app) {
    return new ProjetTutMutuelle\DAO\Adhesion_DetailDAO($app['db']);
    });
    
$app['dao.prestationSante'] = $app->share(function ($app) {
     $prestationDAO = new ProjetTutMutuelle\DAO\Prestation_santeDAO($app['db']);
     $prestationDAO->setBeneficiaireDAO($app['dao.beneficiaire']);
    return $prestationDAO; 
    });
    

// Page d'erreur par defaut
    
    
$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Access denied.';
            break;
        case 404:
            $message = 'The requested resource could not be found.';
            break;
        default:
            $message = "Something went wrong.";
    }
    return $app['twig']->render('error.html.twig', array('message' => $message));
});
    