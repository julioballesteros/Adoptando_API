<?php
/**
 * Created by PhpStorm.
 * User: weeto
 * Date: 2019-05-18
 * Time: 15:47
 */

namespace Project\Pets;


class Pet
{
    public $id;
    public $type;
    public $name;
    public $shelter;
    public $birthdate;
    public $description;
    public $img;

    public function __construct($id, $type, $name, $shelter, $birthdate, $description, $img)
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->shelter = $shelter;
        $this->birthdate = $birthdate;
        $this->description = $description;
        $this->img = $img;
    }
}