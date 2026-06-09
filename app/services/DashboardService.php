<?php

declare(strict_types=1);

require_once "../config/database.php";

class DashboardService
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function obtenerStats(): array
    {
        $stats = [];

        // TOTAL RESERVAS
        $result = $this->conn->query("
            SELECT COUNT(*) AS total FROM reservas
        ");
        $stats['totalReservas'] =
            $result ? (int)$result->fetch_assoc()['total'] : 0;

        // TOTAL USUARIOS
        $result = $this->conn->query("
            SELECT COUNT(*) AS total FROM usuarios
        ");
        $stats['totalUsuarios'] =
            $result ? (int)$result->fetch_assoc()['total'] : 0;

        // TOTAL MESAS
        $result = $this->conn->query("
            SELECT COUNT(*) AS total FROM mesas
        ");
        $stats['totalMesas'] =
            $result ? (int)$result->fetch_assoc()['total'] : 0;

        // RESERVAS HOY
        $result = $this->conn->query("
            SELECT COUNT(*) AS total
            FROM reservas
            WHERE fecha_r = CURDATE()
        ");
        $stats['reservasHoy'] =
            $result ? (int)$result->fetch_assoc()['total'] : 0;

        // GRAFICA
        $result = $this->conn->query("
            SELECT fecha_r, COUNT(*) AS total
            FROM reservas
            GROUP BY fecha_r
            ORDER BY fecha_r ASC
            LIMIT 7
        ");

        $stats['grafica'] =
            $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        return $stats;
    }

    public function obtenerReservas(): array
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
            JOIN usuarios u ON r.id_usuario = u.id_usuario
            JOIN mesas m ON r.id_mesa = m.id_mesa
            JOIN salas s ON m.id_sala = s.id_sala
            JOIN bibliotecas b ON s.id_biblioteca = b.id_biblioteca
            ORDER BY r.fecha_r DESC, r.hora_inicio ASC
        ";

        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}