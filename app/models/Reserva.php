<?php

declare(strict_types=1);

require_once "../config/database.php";

class Reserva {

    private mysqli $conn;

    public function __construct() {

        $this->conn = Database::connect();
    }

    // =========================
    // RESERVAS USUARIO
    // =========================

    public function obtenerPorUsuario(
        int $idUsuario
    ) {

        $stmt = $this->conn->prepare("
            SELECT
                r.*,
                m.numero,
                m.id_mesa,
                s.nombre_s,
                s.id_sala,
                b.nombre_b,
                b.id_biblioteca
            FROM reservas r

            JOIN mesas m
                ON r.id_mesa = m.id_mesa

            JOIN salas s
                ON m.id_sala = s.id_sala

            JOIN bibliotecas b
                ON s.id_biblioteca = b.id_biblioteca

            WHERE r.id_usuario = ?

            ORDER BY
                r.fecha_r DESC,
                r.hora_inicio ASC
        ");

        $stmt->bind_param(
            "i",
            $idUsuario
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    // =========================
    // TODAS LAS RESERVAS
    // =========================

    public function obtenerTodas() {

        $sql = "
            SELECT
                r.*,

                u.nombre_u,

                m.numero,
                m.id_mesa,

                s.nombre_s,
                s.id_sala,

                b.nombre_b,
                b.id_biblioteca

            FROM reservas r

            JOIN usuarios u
                ON r.id_usuario = u.id_usuario

            JOIN mesas m
                ON r.id_mesa = m.id_mesa

            JOIN salas s
                ON m.id_sala = s.id_sala

            JOIN bibliotecas b
                ON s.id_biblioteca = b.id_biblioteca

            ORDER BY
                r.fecha_r DESC,
                r.hora_inicio ASC
        ";

        return $this->conn
            ->query($sql);
    }

    // =========================
    // OBTENER RESERVA
    // =========================

    public function obtenerPorId(
        int $id
    ): ?array {

        $stmt = $this->conn->prepare("
            SELECT
                r.*,

                m.numero,
                m.id_mesa,

                s.nombre_s,
                s.id_sala,

                b.nombre_b,
                b.id_biblioteca

            FROM reservas r

            JOIN mesas m
                ON r.id_mesa = m.id_mesa

            JOIN salas s
                ON m.id_sala = s.id_sala

            JOIN bibliotecas b
                ON s.id_biblioteca = b.id_biblioteca

            WHERE r.id_reserva = ?
        ");

        $stmt->bind_param(
            "i",
            $id
        );

        $stmt->execute();

        $resultado =
            $stmt
                ->get_result()
                ->fetch_assoc();

        return $resultado ?: null;
    }

    // =========================
    // CREAR
    // =========================

    public function crear(
        string $fecha,
        string $inicio,
        string $fin,
        int $usuario,
        int $mesa
    ): bool {

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

    // =========================
    // ACTUALIZAR
    // =========================

    public function actualizar(
        int $id,
        string $fecha,
        string $inicio,
        string $fin,
        int $mesa
    ): bool {

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

    // =========================
    // ELIMINAR
    // =========================

    public function eliminar(
        int $id
    ): bool {

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

    // =========================
    // VALIDAR SOLAPAMIENTO MESA
    // =========================

    public function existeSolapamientoMesa(
        int $mesa,
        string $fecha,
        string $inicio,
        string $fin,
        ?int $ignorar = null
    ): bool {

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

        if ($ignorar !== null) {

            $sql .= "
                AND id_reserva != ?
            ";
        }

        $stmt =
            $this->conn->prepare($sql);

        if ($ignorar !== null) {

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

    // =========================
    // VALIDAR SOLAPAMIENTO USUARIO
    // =========================

    public function existeSolapamientoUsuario(
        int $usuario,
        string $fecha,
        string $inicio,
        string $fin,
        ?int $ignorar = null
    ): bool {

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

        if ($ignorar !== null) {

            $sql .= "
                AND id_reserva != ?
            ";
        }

        $stmt =
            $this->conn->prepare($sql);

        if ($ignorar !== null) {

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

    // =========================
    // STATS DASHBOARD
    // =========================

    public function totalReservas(): int {

        $resultado =
            $this->conn->query("
                SELECT COUNT(*) AS total
                FROM reservas
            ");

        return (int)
            $resultado
                ->fetch_assoc()['total'];
    }

    public function reservasHoy(): int {

        $stmt = $this->conn->prepare("
            SELECT COUNT(*) AS total
            FROM reservas
            WHERE fecha_r = CURDATE()
        ");

        $stmt->execute();

        return (int)
            $stmt
                ->get_result()
                ->fetch_assoc()['total'];
    }

    // =========================
    // GRÁFICA
    // =========================

    public function graficaReservas(): array {

        $resultado =
            $this->conn->query("
                SELECT
                    fecha_r,
                    COUNT(*) AS total

                FROM reservas

                GROUP BY fecha_r

                ORDER BY fecha_r ASC
            ");

        $datos = [];

        while (
            $fila =
                $resultado->fetch_assoc()
        ) {

            $datos[] = $fila;
        }

        return $datos;
    }
}