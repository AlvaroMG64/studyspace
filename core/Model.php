<?php

require_once "../config/database.php";

class Model {

    protected mysqli $db;

    public function __construct() {

        $this->db = Database::connect();
    }
}