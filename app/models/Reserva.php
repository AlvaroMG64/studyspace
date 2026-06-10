<?php

declare(strict_types=1);

require_once BASE_PATH . "/core/Model.php";

class Reserva extends Model
{
    // =========================
    // RESERVAS USUARIO
    // =========================

    public function obtenerPorUsuario(
        int $idUsuario
    ): mysqli_result {

        $stmt = $this->db->prepare("
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
                r.fecha_r ASC,
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

    public function obtenerTodas(): mysqli_result
    {
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
                r.fecha_r ASC,
                r.hora_inicio ASC
        ";

        return $this->db->query($sql);
    }

    // =========================
    // OBTENER POR ID
    // =========================

    public function obtenerPorId(
        int $id
    ): ?array {

        $stmt = $this->db->prepare("
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

        $stmt = $this->db->prepare("
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

        $stmt = $this->db->prepare("
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

        $stmt = $this->db->prepare("
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

            AND hora_inicio < ?
            AND hora_fin > ?
        ";

        if ($ignorar !== null) {
            $sql .= " AND id_reserva != ? ";
        }

        $stmt = $this->db->prepare($sql);

        if ($ignorar !== null) {

            $stmt->bind_param(
                "isssi",
                $mesa,
                $fecha,
                $fin,
                $inicio,
                $ignorar
            );

        } else {

            $stmt->bind_param(
                "isss",
                $mesa,
                $fecha,
                $fin,
                $inicio
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

            AND hora_inicio < ?
            AND hora_fin > ?
        ";

        if ($ignorar !== null) {
            $sql .= " AND id_reserva != ? ";
        }

        $stmt = $this->db->prepare($sql);

        if ($ignorar !== null) {

            $stmt->bind_param(
                "isssi",
                $usuario,
                $fecha,
                $fin,
                $inicio,
                $ignorar
            );

        } else {

            $stmt->bind_param(
                "isss",
                $usuario,
                $fecha,
                $fin,
                $inicio
            );
        }

        $stmt->execute();

        return $stmt
            ->get_result()
            ->num_rows > 0;
    }
}