<?php
/**
 * Created by PhpStorm.
 * User: weeto
 * Date: 2019-05-18
 * Time: 15:11
 */

namespace Project\Pets;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


class PetController
{
    private $dao;

    public function __construct(ContainerInterface $container)
    {
        $dbConnection = $container['dbConnection'];
        $this->dao = new PetDao($dbConnection);
    }

    function getAll(Request $request, Response $response, array $args)
    {
        $animals = $this->dao->getAll();
        return $response->withJson($animals);
    }

    function getPetById(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $animal = $this->dao->getPet($id);
        return $response->withJson($animal);
    }

    function createPet(Request $request, Response $response, array $args)
    {
        $newPet = $request->getParsedBody();
        $pet = $this->dao->createPet($newPet);
        return $response->withJson($pet);
    }

    function updatePet(Request $request, Response $response, array $args)
    {
        $petId = $args['id'];
        $body = $request->getParsedBody();
        $pet = $this->dao->updatePet($petId, $body);
        return $response->withJson($pet);
    }

    function deletePet(Request $request, Response $response, array $args)
    {
        $petId = $args['id'];
        $this->dao->deletePet($petId);
        return $response->withStatus(204);
    }
}