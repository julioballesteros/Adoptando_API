<?php

use Slim\App;
//use Tuupola\Middleware\JwtAuthentication;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new \Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// contenedor que conecta con bases de datos una vez sin tener que repetir
$container['dbConnection'] = function ($c) {
    $dbConnection = new PDO("mysql:host=localhost;dbname=desarrollo_web","root","root");
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return new \Project\Utils\MySqlProjectDao($dbConnection);
};

// contenedor para la autenticacion
$container['authentication'] = function ($c) {
    return new Slim\Middleware\JwtAuthentication(
        [
            "secure" => false,
            "secret" => 'mysecret'
        ]
    );
};
