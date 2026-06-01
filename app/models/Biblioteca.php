<?php

declare(strict_types=1);

require_once "../config/database.php";

class Biblioteca {

    private mysqli $conn;

    public function __construct() {

        $this->conn =
            Database::connect();
    }

    public function obtenerTodas(): mysqli_result
    {
        return $this->conn->query("
            SELECT *
            FROM bibliotecas
            ORDER BY nombre_b ASC
        ");
    }
}