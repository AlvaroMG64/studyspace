<?php

declare(strict_types=1);

require_once "../core/BaseController.php";
require_once "../app/models/Biblioteca.php";
require_once "../app/services/ReservaService.php";

class ReservaController extends BaseController
{
    private ReservaService $service;
    private Biblioteca $bibliotecaModel;

    public function __construct()
    {
        $this->requireAuth();

        $this->service = new ReservaService();
        $this->bibliotecaModel = new Biblioteca();
    }

    // =========================
    // MIS RESERVAS
    // =========================

    public function misReservas(): void
    {
        $reservas = $this->service
            ->obtenerReservasUsuario($_SESSION['id']);

        $this->view("reservas/mis_reservas", [
            "reservas" => $reservas
        ]);
    }

    // =========================
    // FORM CREAR
    // =========================

    public function crear(): void
    {
        $bibliotecas = $this->bibliotecaModel
            ->obtenerTodas()
            ->fetch_all(MYSQLI_ASSOC);

        $this->view("reservas/crear", [
            "bibliotecas" => $bibliotecas
        ]);
    }

    // =========================
    // GUARDAR
    // =========================

    public function guardar(): void
    {
        $fecha = trim($_POST['fecha'] ?? '');
        $inicio = trim($_POST['inicio'] ?? '');
        $fin = trim($_POST['fin'] ?? '');
        $mesa = (int)($_POST['mesa'] ?? 0);
        $usuario = $_SESSION['id'];

        // 🔴 VALIDACIÓN EXTRA (IMPORTANTE)
        if (!$mesa) {
            $this->json([
                "success" => false,
                "message" => "Debes seleccionar una mesa"
            ]);
            return;
        }

        $resultado = $this->service->crearReserva(
            $fecha,
            $inicio,
            $fin,
            $usuario,
            $mesa
        );

        $this->json($resultado);
    }

    // =========================
    // FORM EDITAR
    // =========================

    public function editar(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        $reserva = $this->service->obtenerReserva($id);

        if (!$reserva) {
            die("Reserva no encontrada");
        }

        if (!$this->service->puedeGestionarReserva(
            $reserva,
            $_SESSION['id'],
            $_SESSION['rol']
        )) {
            die("No autorizado");
        }

        $bibliotecas = $this->bibliotecaModel
            ->obtenerTodas()
            ->fetch_all(MYSQLI_ASSOC);

        $this->view("reservas/editar", [
            "reserva" => $reserva,
            "bibliotecas" => $bibliotecas
        ]);
    }

    // =========================
    // ACTUALIZAR
    // =========================

    public function actualizar(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $fecha = trim($_POST['fecha'] ?? '');
        $inicio = trim($_POST['inicio'] ?? '');
        $fin = trim($_POST['fin'] ?? '');
        $mesa = (int)($_POST['mesa'] ?? 0);

        $usuario = $_SESSION['id'];
        $rol = $_SESSION['rol'];

        $resultado = $this->service->actualizarReserva(
            $id,
            $fecha,
            $inicio,
            $fin,
            $mesa,
            $usuario,
            $rol
        );

        $this->json($resultado);
    }

    // =========================
    // ELIMINAR
    // =========================

    public function eliminar(): void
    {
        $id = (int)($_POST['id'] ?? 0);

        $resultado = $this->service->eliminarReserva(
            $id,
            $_SESSION['id'],
            $_SESSION['rol']
        );

        $this->json($resultado);
    }
}