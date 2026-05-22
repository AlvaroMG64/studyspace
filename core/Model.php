<?php

declare(strict_types=1);

require_once __DIR__ .
    "/../config/database.php";

class Model {

    protected mysqli $db;

    public function __construct() {

        $this->db = Database::connect();
    }
}