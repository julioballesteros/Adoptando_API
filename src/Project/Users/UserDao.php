<?php
/**
 * Created by PhpStorm.
 * User: weeto
 * Date: 2019-05-18
 * Time: 16:34
 */

namespace Project\Users;

use Project\Utils\ProjectDao;
use DateTime;
use Firebase\JWT\JWT;


class UserDao
{
    private $dbConnection;

    public function __construct(ProjectDao $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM USER";
        return $this->dbConnection->fetchAll($sql);
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM USER WHERE id = ?";
        return $this->dbConnection->fetch($sql, array($id));
    }

    public function createUser($user)
    {
        $sql = "INSERT INTO USER (name, mail, password) VALUES (?, ?, ?)";
        $id = $this->dbConnection->insert($sql, array($user['name'], $user['mail'], $user['password']));

        $user = $this->getUser($id);
        $user->token = $this->generateToken($user->id);
        return $user;
    }

    public function updateUser($userId, array $user)
    {
        $sql = "UPDATE USER SET name = ?, mail = ?, token = ? WHERE id = ?";
        $this->dbConnection->execute($sql, array($user['name'], $user['mail'], $user['token'], $userId));

        return $this->getUser($userId);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM USER WHERE id = ?";
        $this->dbConnection->execute($sql, array($id));
    }

    public function loginUser($body)
    {
        $mail = $body['mail'];
        $password = $body['password'];
        $sql = "SELECT * FROM USER WHERE mail = ?";
        $user = $this->dbConnection->fetch($sql, array($mail));
        if ($user->password === $password) {
            $user->token = $this->generateToken($user->id);
            return $user;
        } else {
            return false;
        }
    }

    public function generateToken($userId)
    {
        $now = new DateTime();
        $future = new DateTime("now +1 year");
        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => base64_encode(random_bytes(16)),
            'iss' => 'localhost:8888',  // Issuer
            "id" => $userId,
        ];
        $secret = 'mysecret';
        $token = JWT::encode($payload, $secret, "HS256");
        return $token;
    }
}