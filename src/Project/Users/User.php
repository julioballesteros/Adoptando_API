<?php
/**
 * Created by PhpStorm.
 * User: weeto
 * Date: 2019-05-18
 * Time: 16:22
 */

namespace Project\Users;


class User
{
    public $id;
    public $name;
    public $mail;

    public function __construct($id, $name, $mail)
    {
        $this->id = $id;
        $this->name = $name;
        $this->mail = $mail;
    }
}