<?php

require_once __DIR__.'/Aplicacion.php';


ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

$host='localhost';
$usuario='ansus_bowling';
$contr='andreayjesus';
$bbdd='ansus';

$arrayBD = array('host'=>$host, 'bd'=>$bbdd, 'user'=>$usuario, 'pass'=>$contr);

$app = Aplicacion::getSingleton();
$app->init($arrayBD);

register_shutdown_function(array($app, 'cierre'));
?>