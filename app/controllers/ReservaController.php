<?php

require_once "../app/models/Reserva.php";
require_once "../config/database.php";

class ReservaController extends Controller {

    private Reserva $model;
    private mysqli $conn;

    public function __construct() {

        if (!isset($_SESSION['id'])) {

            header("Location: /studyspace/public/login");
            exit;
        }

        $this->model = new Reserva();
        $this->conn = Database::connect();
    }

    // LISTADO
    public function misReservas() {

        $reservas = $this->model
            ->obtenerPorUsuario(
                $_SESSION['id']
            );

        $this->view(
            "reservas/mis_reservas",
            [
                "reservas" => $reservas
            ]
        );
    }

    // FORM CREAR
    public function crear() {

        $bibliotecas = $this->conn->query("
        SELECT *
        FROM bibliotecas
        ORDER BY nombre_b ASC
        ");

        $this->view(
            "reservas/crear",
            [
                "bibliotecas" => $bibliotecas
            ]
        );
    }

    // GUARDAR
    public function guardar() {

        $fecha = $_POST['fecha'] ?? '';
        $inicio = $_POST['inicio'] ?? '';
        $fin = $_POST['fin'] ?? '';
        $mesa = intval($_POST['mesa'] ?? 0);

        $usuario = $_SESSION['id'];

        // VALIDACIONES

        if (
            !$fecha ||
            !$inicio ||
            !$fin ||
            !$mesa
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Debes completar todos los campos"
            ]);

            exit;
        }

        if ($fecha < date("Y-m-d")) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "No puedes reservar en fechas pasadas"
            ]);

            exit;
        }

        if ($inicio >= $fin) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "La hora de fin debe ser posterior a la hora de inicio"
            ]);

            exit;
        }

        // SOLAPAMIENTO MESA

        if (
            $this->model
            ->existeSolapamientoMesa(
                $mesa,
                $fecha,
                $inicio,
                $fin
            )
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "La mesa ya está ocupada en ese horario"
            ]);

            exit;
        }

        // SOLAPAMIENTO USUARIO

        if (
            $this->model
            ->existeSolapamientoUsuario(
                $usuario,
                $fecha,
                $inicio,
                $fin
            )
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Ya tienes otra reserva en ese horario"
            ]);

            exit;
        }

        // CREAR

        $this->model->crear(
            $fecha,
            $inicio,
            $fin,
            $usuario,
            $mesa
        );

        echo json_encode([
            "success" => true
        ]);
    }

    // FORM EDITAR
    public function editar() {

        $id = intval($_GET['id'] ?? 0);

        $reserva = $this->model
            ->obtenerPorId($id);

        if (!$reserva) {
            die("Reserva no encontrada");
        }

        if (
            $reserva['id_usuario']
            != $_SESSION['id']
        ) {

            die("No autorizado");
        }

        $this->view(
            "reservas/editar",
            [
                "reserva" => $reserva
            ]
        );
    }

    // ACTUALIZAR
    public function actualizar() {

        $id = intval($_POST['id'] ?? 0);

        $fecha = $_POST['fecha'] ?? '';
        $inicio = $_POST['inicio'] ?? '';
        $fin = $_POST['fin'] ?? '';
        $mesa = intval($_POST['mesa'] ?? 0);

        $usuario = $_SESSION['id'];

        if (
            !$fecha ||
            !$inicio ||
            !$fin ||
            !$mesa
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Debes completar todos los campos"
            ]);

            exit;
        }

        if ($inicio >= $fin) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "La hora de fin debe ser posterior a la hora de inicio"
            ]);

            exit;
        }

        if (
            $this->model
            ->existeSolapamientoMesa(
                $mesa,
                $fecha,
                $inicio,
                $fin,
                $id
            )
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "La mesa ya está ocupada"
            ]);

            exit;
        }

        if (
            $this->model
            ->existeSolapamientoUsuario(
                $usuario,
                $fecha,
                $inicio,
                $fin,
                $id
            )
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Ya tienes otra reserva en ese horario"
            ]);

            exit;
        }

        $this->model->actualizar(
            $id,
            $fecha,
            $inicio,
            $fin,
            $mesa
        );

        echo json_encode([
            "success" => true
        ]);
    }

    // ELIMINAR
    public function eliminar() {

        $id = intval($_POST['id'] ?? 0);

        $reserva = $this->model
            ->obtenerPorId($id);

        if (!$reserva) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Reserva no encontrada"
            ]);

            exit;
        }

        if (
            $reserva['id_usuario']
            != $_SESSION['id']
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "No autorizado"
            ]);

            exit;
        }

        $this->model->eliminar($id);

        echo json_encode([
            "success" => true
        ]);
    }

}