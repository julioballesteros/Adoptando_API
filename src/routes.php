<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Project\Pets\PetController;
use Project\Users\UserController;

//Autenticacion de usuario
$authentication = $app->getContainer()->get('authentication');

// Rutas de gestion de mascotas

// obtener todas las mascotas
$app->get('/pets', PetController::class . ':getAll');

//Obtener un animal por id
$app->get('/pet/{id}', PetController::class . ':getPetById');

//Registrar un animal
$app->post('/pets', PetController::class . ':createPet')->add($authentication);

//Actualizar animal
$app->put('/pet/{id}', PetController::class . ':updatePet')->add($authentication);

//Eliminar animal
$app->delete('/pet/{id}', PetController::class . ':deletePet')->add($authentication);


//Rutas de gestion de usuarios

// obtener todos los usuarios
$app->get('/users', UserController::class . ':getAll');

//Obtener un usuario por id
$app->get('/user/{id}', UserController::class . ':getUserById');

//Crear un usuario
$app->post('/users', UserController::class . ':createUser');

//Actualizar usuario
$app->put('/user/{id}', UserController::class . ':updateUser')->add($authentication);

//Eliminar usuario
$app->delete('/user/{id}', UserController::class . ':deleteUser')->add($authentication);

//Login de usuario
$app->post('/login', UserController::class . ':loginUser');

/*
return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
};
*/

