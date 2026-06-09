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
        $this->service = new ReservaService();
        $this->bibliotecaModel = new Biblioteca();
    }

    public function misReservas(): void
    {
        $this->requireAuth();

        $reservas = $this->service->obtenerReservasUsuario($_SESSION['id']);

        $this->view("reservas/mis_reservas", [
            "reservas" => $reservas
        ]);
    }

    public function crear(): void
    {
        $this->requireAuth();

        $bibliotecas = $this->bibliotecaModel->obtenerTodas();

        $this->view("reservas/crear", [
            "bibliotecas" => $bibliotecas
        ]);
    }

    public function guardar(): void
    {
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            http_response_code(403);
            exit('CSRF inválido');
        }

        $this->requireAuthApi();

        $fecha = trim($_POST['fecha'] ?? '');
        $inicio = trim($_POST['inicio'] ?? '');
        $fin = trim($_POST['fin'] ?? '');
        $mesa = (int)($_POST['mesa'] ?? 0);
        $usuario = (int)$_SESSION['id'];

        if (!$mesa) {

            $this->json([
                "success" => false,
                "message" => "Debes seleccionar una mesa"
            ]);
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

    public function editar(): void
    {
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);

        $reserva = $this->service->obtenerReservaSegura(
            $id,
            $_SESSION['id'],
            $_SESSION['rol']
        );

        if (!$reserva) {

            http_response_code(403);

            die("No autorizado o reserva no encontrada");
        }

        $bibliotecas = $this->bibliotecaModel->obtenerTodas();

        $this->view("reservas/editar", [
            "reserva" => $reserva,
            "bibliotecas" => $bibliotecas
        ]);
    }

    public function actualizar(): void
    {
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            http_response_code(403);
            exit('CSRF inválido');
        }

        $this->requireAuthApi();

        $id = (int)($_POST['id'] ?? 0);
        $fecha = trim($_POST['fecha'] ?? '');
        $inicio = trim($_POST['inicio'] ?? '');
        $fin = trim($_POST['fin'] ?? '');
        $mesa = (int)($_POST['mesa'] ?? 0);

        $resultado = $this->service->actualizarReserva(
            $id,
            $fecha,
            $inicio,
            $fin,
            $mesa,
            $_SESSION['id'],
            $_SESSION['rol']
        );

        $this->json($resultado);
    }

    public function eliminar(): void
    {
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            http_response_code(403);
            exit('CSRF inválido');
        }
        
        $this->requireAuthApi();

        $id = (int)($_POST['id'] ?? 0);

        $resultado = $this->service->eliminarReserva(
            $id,
            $_SESSION['id'],
            $_SESSION['rol']
        );

        $this->json($resultado);
    }

    /**
     * API JSON
     */
    public function misReservasApi(): void
    {
        $this->requireAuthApi();

        $reservas = $this->service->obtenerReservasUsuario($_SESSION['id']);

        $data = [];

        while ($r = $reservas->fetch_assoc()) {

            $data[] = [
                "id" => (int)$r["id_reserva"],
                "nombre" => $r["nombre_s"] . " - Mesa " . $r["numero"],
            ];
        }

        $this->json($data);
    }
}