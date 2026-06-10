<?php

declare(strict_types=1);

require_once BASE_PATH . "/config/database.php";

abstract class Model
{
    protected mysqli $db;

    public function __construct()
    {
        $this->db =
            Database::connect();
    }
}