<?php

declare(strict_types=1);

require_once "../config/database.php";
require_once "../app/models/Reserva.php";

class ApiController extends Controller
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    // SALAS POR BIBLIOTECA
    public function salas(): void
    {
        header('Content-Type: application/json');

        $biblioteca = intval(
            $_GET['biblioteca'] ?? 0
        );

        $stmt = $this->conn->prepare("
            SELECT *
            FROM salas
            WHERE id_biblioteca = ?
            ORDER BY nombre_s ASC
        ");

        $stmt->bind_param(
            "i",
            $biblioteca
        );

        $stmt->execute();

        echo json_encode(
            $stmt
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC)
        );
    }

    // MESAS POR SALA
    public function mesas(): void
    {
        header('Content-Type: application/json');

        $sala = intval(
            $_GET['sala'] ?? 0
        );

        $stmt = $this->conn->prepare("
            SELECT *
            FROM mesas
            WHERE id_sala = ?
            ORDER BY numero ASC
        ");

        $stmt->bind_param(
            "i",
            $sala
        );

        $stmt->execute();

        echo json_encode(
            $stmt
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC)
        );
    }

    // STATS DASHBOARD
    public function stats(): void
    {
        header('Content-Type: application/json');

        $stats = [];

        // TOTAL RESERVAS
        $result = $this->conn->query("
            SELECT COUNT(*) AS total
            FROM reservas
        ");

        $stats['totalReservas'] =
            $result->fetch_assoc()['total'];

        // TOTAL USUARIOS
        $result = $this->conn->query("
            SELECT COUNT(*) AS total
            FROM usuarios
        ");

        $stats['totalUsuarios'] =
            $result->fetch_assoc()['total'];

        // TOTAL MESAS
        $result = $this->conn->query("
            SELECT COUNT(*) AS total
            FROM mesas
        ");

        $stats['totalMesas'] =
            $result->fetch_assoc()['total'];

        // RESERVAS HOY
        $result = $this->conn->query("
            SELECT COUNT(*) AS total
            FROM reservas
            WHERE fecha_r = CURDATE()
        ");

        $stats['reservasHoy'] =
            $result->fetch_assoc()['total'];

        // GRAFICA
        $result = $this->conn->query("
            SELECT
                fecha_r,
                COUNT(*) AS total
            FROM reservas
            GROUP BY fecha_r
            ORDER BY fecha_r ASC
            LIMIT 7
        ");

        $stats['grafica'] =
            $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($stats);
    }
}