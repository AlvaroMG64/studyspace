<?php

declare(strict_types=1);

require_once "../core/Model.php";

class Usuario extends Model
{
    // =========================
    // LOGIN
    // =========================

    public function obtenerPorEmail(
        string $email
    ): ?array {

        $sql = "
            SELECT *
            FROM usuarios
            WHERE email = ?
            LIMIT 1
        ";

        $stmt =
            $this->db->prepare($sql);

        $stmt->bind_param(
            "s",
            $email
        );

        $stmt->execute();

        $resultado =
            $stmt->get_result();

        $usuario =
            $resultado->fetch_assoc();

        return $usuario ?: null;
    }

    // =========================
    // REGISTRO
    // =========================

    public function crear(
        string $nombre,
        string $email,
        string $passwordHash
    ): bool {

        $sql = "
            INSERT INTO usuarios (
                nombre_u,
                email,
                contrasena,
                rol
            )
            VALUES (?, ?, ?, 'usuario')
        ";

        $stmt =
            $this->db->prepare($sql);

        $stmt->bind_param(
            "sss",
            $nombre,
            $email,
            $passwordHash
        );

        return $stmt->execute();
    }

    // =========================
    // EXISTE EMAIL
    // =========================

    public function existeEmail(
        string $email
    ): bool {

        $sql = "
            SELECT id_usuario
            FROM usuarios
            WHERE email = ?
            LIMIT 1
        ";

        $stmt =
            $this->db->prepare($sql);

        $stmt->bind_param(
            "s",
            $email
        );

        $stmt->execute();

        $resultado =
            $stmt->get_result();

        return $resultado->num_rows > 0;
    }

    // =========================
    // TOTAL USUARIOS
    // =========================

    public function totalUsuarios(): int
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM usuarios
        ";

        $resultado =
            $this->db->query($sql);

        $fila =
            $resultado->fetch_assoc();

        return (int)$fila['total'];
    }
}