<?php
/**
 * Created by PhpStorm.
 * User: weeto
 * Date: 2019-05-18
 * Time: 15:17
 */

namespace Project\Pets;

use Project\Pets\Pet;
use Project\Utils\ProjectDao;



class PetDao
{
    private $dbConnection;

    public function __construct(ProjectDao $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }


    public function getAll()
    {
        $sql = "SELECT * FROM PET";
        return $this->dbConnection->fetchAll($sql);
    }

    public function getPet($id)
    {
        $sql = "SELECT * FROM PET WHERE id = ?";
        return $this->dbConnection->fetch($sql, array($id));
    }

    public function createPet($pet)
    {
        $sql = "INSERT INTO PET (type, name, shelter, birthdate, description, img) VALUES (?, ?, ?, ?, ?, ?)";
        $id = $this->dbConnection->insert($sql, array($pet['type'], $pet['name'], $pet['shelter'], $pet['birthdate'], $pet['description'], $pet['image']));

        $newPet = $this->getPet($id);
        return $newPet;
    }

    public function updatePet($animalId, array $animal)
    {
        $sql = "UPDATE PET SET name = ?, description = ? WHERE id = ?";
        $this->dbConnection->execute($sql, array($animal['name'], $animal['description'], $animalId));

        return $this->getPet($animalId);
    }

    public function deletePet($id)
    {
        $sql = "DELETE FROM PET WHERE id = ?";
        $this->dbConnection->execute($sql, array($id));
    }


}