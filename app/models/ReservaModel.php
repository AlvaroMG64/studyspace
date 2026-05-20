<?php

require_once "../config/database.php";

class Reserva {

    private mysqli $conn;

    public function __construct() {

        $this->conn = Database::connect();
    }

    // OBTENER RESERVAS DE USUARIO
    public function obtenerPorUsuario($idUsuario) {

        $stmt = $this->conn->prepare("
        SELECT
            r.*,
            m.numero,
            s.nombre_s,
            b.nombre_b
        FROM reservas r
        JOIN mesas m
            ON r.id_mesa = m.id_mesa
        JOIN salas s
            ON m.id_sala = s.id_sala
        JOIN bibliotecas b
            ON s.id_biblioteca = b.id_biblioteca
        WHERE r.id_usuario = ?
        ORDER BY fecha_r DESC,
                 hora_inicio ASC
        ");

        $stmt->bind_param(
            "i",
            $idUsuario
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    // OBTENER RESERVA
    public function obtenerPorId($id) {

        $stmt = $this->conn->prepare("
        SELECT *
        FROM reservas
        WHERE id_reserva = ?
        ");

        $stmt->bind_param(
            "i",
            $id
        );

        $stmt->execute();

        return $stmt
            ->get_result()
            ->fetch_assoc();
    }

    // CREAR RESERVA
    public function crear(
        $fecha,
        $inicio,
        $fin,
        $usuario,
        $mesa
    ) {

        $stmt = $this->conn->prepare("
        INSERT INTO reservas
        (
            fecha_r,
            hora_inicio,
            hora_fin,
            id_usuario,
            id_mesa
        )
        VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssii",
            $fecha,
            $inicio,
            $fin,
            $usuario,
            $mesa
        );

        return $stmt->execute();
    }

    // ACTUALIZAR
    public function actualizar(
        $id,
        $fecha,
        $inicio,
        $fin,
        $mesa
    ) {

        $stmt = $this->conn->prepare("
        UPDATE reservas
        SET
            fecha_r = ?,
            hora_inicio = ?,
            hora_fin = ?,
            id_mesa = ?
        WHERE id_reserva = ?
        ");

        $stmt->bind_param(
            "sssii",
            $fecha,
            $inicio,
            $fin,
            $mesa,
            $id
        );

        return $stmt->execute();
    }

    // ELIMINAR
    public function eliminar($id) {

        $stmt = $this->conn->prepare("
        DELETE FROM reservas
        WHERE id_reserva = ?
        ");

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }

    // VALIDAR SOLAPAMIENTO MESA
    public function existeSolapamientoMesa(
        $mesa,
        $fecha,
        $inicio,
        $fin,
        $ignorar = null
    ) {

        $sql = "
        SELECT id_reserva
        FROM reservas
        WHERE id_mesa = ?
        AND fecha_r = ?
        AND NOT (
            hora_fin <= ?
            OR hora_inicio >= ?
        )
        ";

        if ($ignorar) {
            $sql .= "
            AND id_reserva != ?
            ";
        }

        $stmt = $this->conn->prepare($sql);

        if ($ignorar) {

            $stmt->bind_param(
                "isssi",
                $mesa,
                $fecha,
                $inicio,
                $fin,
                $ignorar
            );

        } else {

            $stmt->bind_param(
                "isss",
                $mesa,
                $fecha,
                $inicio,
                $fin
            );
        }

        $stmt->execute();

        return $stmt
            ->get_result()
            ->num_rows > 0;
    }

    // VALIDAR SOLAPAMIENTO USUARIO
    public function existeSolapamientoUsuario(
        $usuario,
        $fecha,
        $inicio,
        $fin,
        $ignorar = null
    ) {

        $sql = "
        SELECT id_reserva
        FROM reservas
        WHERE id_usuario = ?
        AND fecha_r = ?
        AND NOT (
            hora_fin <= ?
            OR hora_inicio >= ?
        )
        ";

        if ($ignorar) {
            $sql .= "
            AND id_reserva != ?
            ";
        }

        $stmt = $this->conn->prepare($sql);

        if ($ignorar) {

            $stmt->bind_param(
                "isssi",
                $usuario,
                $fecha,
                $inicio,
                $fin,
                $ignorar
            );

        } else {

            $stmt->bind_param(
                "isss",
                $usuario,
                $fecha,
                $inicio,
                $fin
            );
        }

        $stmt->execute();

        return $stmt
            ->get_result()
            ->num_rows > 0;
    }
}