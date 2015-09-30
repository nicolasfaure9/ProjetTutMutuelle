<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'oci8',
    'host'     => 'epulgold.univ-lyon1.fr',
    'dbname' =>'oraepul1',
    'port'     => '1521',
    'user'     => 'PBDALG7',
    'password' => 'PBDALG7',
    'charset'  => 'utf8',
);

// enable the debug mode
$app['debug'] = true;


// define log parameters
$app['monolog.level'] = 'INFO';
