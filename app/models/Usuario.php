<?php

require_once "../config/database.php";

class Usuario {

    private mysqli $conn;

    public function __construct() {

        $this->conn = Database::connect();
    }

    public function obtenerPorEmail($email) {

        $stmt = $this->conn->prepare("
        SELECT *
        FROM usuarios
        WHERE email = ?
        ");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function crear($nombre, $email, $password) {

        $hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $this->conn->prepare("
        INSERT INTO usuarios
        (
            nombre_u,
            email,
            contrasena
        )
        VALUES (?, ?, ?)
        ");

        $stmt->bind_param(
            "sss",
            $nombre,
            $email,
            $hash
        );

        return $stmt->execute();
    }
}