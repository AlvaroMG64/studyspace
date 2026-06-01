<?php

declare(strict_types=1);

require_once "../core/Controller.php";

require_once "../config/database.php";

require_once "../app/models/Reserva.php";
require_once "../app/models/Biblioteca.php";

class ReservaController extends Controller {

    private Reserva $model;

    /** @var Biblioteca */
    private $bibliotecaModel;

    private mysqli $conn;

    public function __construct() {

        if (!isset($_SESSION['id'])) {

            header(
                "Location: /studyspace/public/login"
            );

            exit;
        }

        $this->model =
            new Reserva();

        $this->bibliotecaModel =
            new Biblioteca();

        $this->conn =
            Database::connect();
    }

    // =========================
    // MIS RESERVAS
    // =========================

    public function misReservas(): void
    {
        $reservas =
            $this->model
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

    // =========================
    // CREAR
    // =========================

    public function crear(): void
    {
        $bibliotecas =
            $this->bibliotecaModel
                ->obtenerTodas()
                ->fetch_all(MYSQLI_ASSOC);

        $this->view(
            "reservas/crear",
            [
                "bibliotecas" => $bibliotecas
            ]
        );
    }

    // =========================
    // GUARDAR
    // =========================

    public function guardar(): void
    {
        header(
            "Content-Type: application/json"
        );

        $fecha =
            trim($_POST['fecha'] ?? '');

        $inicio =
            trim($_POST['inicio'] ?? '');

        $fin =
            trim($_POST['fin'] ?? '');

        $mesa =
            (int)($_POST['mesa'] ?? 0);

        $usuario =
            $_SESSION['id'];

        // VALIDAR CAMPOS

        if (
            !$fecha ||
            !$inicio ||
            !$fin ||
            !$mesa
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Todos los campos son obligatorios"
            ]);

            exit;
        }

        // VALIDAR FECHA

        if ($fecha < date("Y-m-d")) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "No se pueden realizar reservas en fechas pasadas"
            ]);

            exit;
        }

        // VALIDAR HORARIO

        if ($inicio >= $fin) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "La fecha de fin debe ser posterior a la de inicio"
            ]);

            exit;
        }

        // VALIDAR SOLAPAMIENTO MESA

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

        // VALIDAR SOLAPAMIENTO USUARIO

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
                    "Ya existe una reserva en ese horario"
            ]);

            exit;
        }

        // CREAR

        $ok =
            $this->model->crear(
                $fecha,
                $inicio,
                $fin,
                $usuario,
                $mesa
            );

        echo json_encode([
            "success" => $ok
        ]);

        exit;
    }

    // =========================
    // FORM EDITAR
    // =========================

    public function editar(): void
    {
        $id =
            (int)($_GET['id'] ?? 0);

        $reserva =
            $this->model
                ->obtenerPorId($id);

        if (!$reserva) {

            die("Reserva no encontrada");
        }

        // SOLO propietario o admin

        if (
            $_SESSION['rol'] !== 'admin'
            && $reserva['id_usuario'] != $_SESSION['id']
        ) {

            die("No autorizado");
        }

        $bibliotecas =
            $this->bibliotecaModel
                ->obtenerTodas()
                ->fetch_all(MYSQLI_ASSOC);

        $this->view(
            "reservas/editar",
            [
                "reserva" => $reserva,
                "bibliotecas" => $bibliotecas
            ]
        );
    }

    // =========================
    // ACTUALIZAR
    // =========================

    public function actualizar(): void
    {
        header(
            "Content-Type: application/json"
        );

        $id =
            (int)($_POST['id'] ?? 0);

        $fecha =
            trim($_POST['fecha'] ?? '');

        $inicio =
            trim($_POST['inicio'] ?? '');

        $fin =
            trim($_POST['fin'] ?? '');

        $mesa =
            (int)($_POST['mesa'] ?? 0);

        $usuario =
            $_SESSION['id'];

        // VALIDAR CAMPOS

        if (
            !$id ||
            !$fecha ||
            !$inicio ||
            !$fin ||
            !$mesa
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Todos los campos son obligatorios"
            ]);

            exit;
        }

        // VALIDAR FECHA

        if ($fecha < date("Y-m-d")) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "No se pueden realizar reservas en fechas pasadas"
            ]);

            exit;
        }

        // VALIDAR HORARIO

        if ($inicio >= $fin) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "La fecha de fin debe ser posterior a la de inicio"
            ]);

            exit;
        }

        // VALIDAR RESERVA

        $reserva =
            $this->model
                ->obtenerPorId($id);

        if (!$reserva) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Reserva no encontrada"
            ]);

            exit;
        }

        // VALIDAR PERMISOS

        if (
            $_SESSION['rol'] !== 'admin'
            && $reserva['id_usuario'] != $usuario
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "No autorizado"
            ]);

            exit;
        }

        // VALIDAR SOLAPAMIENTO MESA

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
                    "La mesa ya está ocupada en ese horario"
            ]);

            exit;
        }

        // VALIDAR SOLAPAMIENTO USUARIO

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
                    "Ya existe una reserva en ese horario"
            ]);

            exit;
        }

        // ACTUALIZAR

        $ok =
            $this->model
                ->actualizar(
                    $id,
                    $fecha,
                    $inicio,
                    $fin,
                    $mesa
                );

        if (!$ok) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Error actualizando reserva"
            ]);

            exit;
        }

        echo json_encode([
            "success" => true
        ]);

        exit;
    }

    // =========================
    // ELIMINAR
    // =========================

    public function eliminar(): void
    {
        header(
            "Content-Type: application/json"
        );

        $id =
            (int)($_POST['id'] ?? 0);

        $reserva =
            $this->model
                ->obtenerPorId($id);

        if (!$reserva) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "Reserva no encontrada"
            ]);

            exit;
        }

        // SOLO propietario o admin

        if (
            $_SESSION['rol'] !== 'admin'
            && $reserva['id_usuario'] != $_SESSION['id']
        ) {

            echo json_encode([
                "success" => false,
                "message" =>
                    "No autorizado"
            ]);

            exit;
        }

        $ok =
            $this->model
                ->eliminar($id);

        echo json_encode([
            "success" => $ok
        ]);

        exit;
    }
}