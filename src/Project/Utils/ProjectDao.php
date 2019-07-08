<?php
/**
 * Created by PhpStorm.
 * User: weeto
 * Date: 2019-05-18
 * Time: 15:49
 */

namespace Project\Utils;

interface ProjectDao
{
    public function fetchAll($sql, $params = null);

    public function fetch($sql, $params = null);

    public function execute($sql, $params = null);

    public function insert($sql, $params = null);
}