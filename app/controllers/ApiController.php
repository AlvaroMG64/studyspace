<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../../config/database.php';

class ApiController extends Controller {

    private mysqli $conn;
    private Reserva $reservaModel;

    public function __construct() {

        $this->conn = Database::connect();
        $this->reservaModel = new Reserva();
    }

    // OBTENER SALAS
    public function salas(): void {

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

        $result = $stmt
            ->get_result()
            ->fetch_all(MYSQLI_ASSOC);

        echo json_encode($result);
    }

    // OBTENER MESAS
    public function mesas(): void {

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

        $result = $stmt
            ->get_result()
            ->fetch_all(MYSQLI_ASSOC);

        echo json_encode($result);
    }

    // STATS DASHBOARD
    public function stats(): void {

        header('Content-Type: application/json');

        $stats = [];

        // TOTAL RESERVAS
        $query = $this->conn->query("
        SELECT COUNT(*) AS total
        FROM reservas
        ");

        $stats['totalReservas'] =
            $query->fetch_assoc()['total'];

        // TOTAL USUARIOS
        $query = $this->conn->query("
        SELECT COUNT(*) AS total
        FROM usuarios
        ");

        $stats['totalUsuarios'] =
            $query->fetch_assoc()['total'];

        // TOTAL MESAS
        $query = $this->conn->query("
        SELECT COUNT(*) AS total
        FROM mesas
        ");

        $stats['totalMesas'] =
            $query->fetch_assoc()['total'];

        // RESERVAS HOY
        $query = $this->conn->query("
        SELECT COUNT(*) AS total
        FROM reservas
        WHERE fecha_r = CURDATE()
        ");

        $stats['reservasHoy'] =
            $query->fetch_assoc()['total'];

        // GRÁFICA
        $query = $this->conn->query("
        SELECT
            fecha_r,
            COUNT(*) AS total
        FROM reservas
        GROUP BY fecha_r
        ORDER BY fecha_r ASC
        LIMIT 7
        ");

        $stats['grafica'] =
            $query->fetch_all(MYSQLI_ASSOC);

        echo json_encode($stats);
    }

    // ELIMINAR RESERVA
    public function eliminarReserva(): void {

        header('Content-Type: application/json');

        if (!isset($_SESSION['id'])) {

            echo json_encode([
                'success' => false,
                'message' => 'No autorizado'
            ]);

            exit;
        }

        $id = intval($_POST['id'] ?? 0);

        $reserva = $this->reservaModel
            ->obtenerPorId($id);

        if (!$reserva) {

            echo json_encode([
                'success' => false,
                'message' => 'Reserva no encontrada'
            ]);

            exit;
        }

        if (
            intval($reserva['id_usuario'])
            !== intval($_SESSION['id'])
        ) {

            echo json_encode([
                'success' => false,
                'message' => 'No autorizado'
            ]);

            exit;
        }

        $this->reservaModel->eliminar($id);

        echo json_encode([
            'success' => true
        ]);
    }
}