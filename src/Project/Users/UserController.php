<?php
/**
 * Created by PhpStorm.
 * User: weeto
 * Date: 2019-05-18
 * Time: 16:34
 */

namespace Project\Users;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


class UserController
{
    private $dao;

    public function __construct(ContainerInterface $container)
    {
        $dbConnection = $container['dbConnection'];
        $this->dao = new UserDao($dbConnection);
    }

    function getAll(Request $request, Response $response, array $args)
    {
        $users = $this->dao->getAll();
        return $response->withJson($users);
    }

    function getUserById(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $user = $this->dao->getUser($id);
        return $response->withJson($user);
    }

    function createUser(Request $request, Response $response, array $args){
        $newUser = $request->getParsedBody();
        $user = $this->dao->createUser($newUser);
        return $response->withJson($user);
    }

    function updateUser(Request $request, Response $response, array $args){

        if ($requestUserId = $request->getAttribute('token')->id) {
            $userId = $args['id'];
            if ($requestUserId === $userId) {
                $body = $request->getParsedBody();
                $user = $this->dao->updateUser($userId, $body);
                return $response->withJson($user);
            } else {
                return $response->withStatus(401);
            }
        } else {
            return $response->withStatus(404);
        }
    }

    function deleteUser(Request $request, Response $response, array $args)
    {
        if ($requestUserId = $request->getAttribute('token')->id) {
            $userId = $args['id'];
            if ($requestUserId === $userId) {
                $this->dao->deleteUser($userId);
                return $response->withStatus(204);
            }
        }
        return $response->withStatus(404);
    }

    function loginUser(Request $request, Response $response, array $args)
    {
        $body = $request->getParsedBody();
        if ($user = $this->dao->loginUser($body)) {
            return $response->withJson($user);
        } else {
            return $response->withStatus(401);
        }
    }
}