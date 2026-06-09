<?php

declare(strict_types=1);

require_once "../core/BaseController.php";
require_once "../app/services/AuthService.php";
require_once "../app/models/Reserva.php";

class AuthController extends BaseController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function home(): void
    {
        $this->requireAuth();

        if ($_SESSION['rol'] === 'admin') {

            $reservaModel = new Reserva();

            $reservas = $reservaModel
                ->obtenerTodas()
                ->fetch_all(MYSQLI_ASSOC);

            $this->view("dashboard/admin", [
                "reservas" => $reservas
            ]);

            return;
        }

        $this->view("dashboard/usuario");
    }

    public function login(): void
    {
        $this->view("auth/login");
    }

    public function autenticar(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {

            $_SESSION['error'] =
                "Todos los campos son obligatorios";

            $this->redirect(base_url('login'));
        }

        $user =
            $this->authService
                ->login($email, $password);

        if (!$user) {

            $_SESSION['error'] =
                "Usuario o contraseña incorrectos";

            $this->redirect(base_url('login'));
        }

        session_regenerate_id(true);

        $_SESSION['id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];

        $_SESSION['last_activity'] = time();

        $_SESSION['login_success'] = true;

        $this->redirect(base_url(''));
    }

    public function registro(): void
    {
        $this->view("auth/registro");
    }

    public function guardarRegistro(): void
    {
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (
            empty($nombre) ||
            empty($email) ||
            empty($password)
        ) {

            $_SESSION['error'] =
                "Todos los campos son obligatorios";

            $this->redirect(base_url('registro'));
        }

        $ok =
            $this->authService
                ->registrar(
                    $nombre,
                    $email,
                    $password
                );

        if (!$ok) {

            $_SESSION['error'] =
                "El email ya existe";

            $this->redirect(base_url('registro'));
        }

        $_SESSION['success'] =
            "Cuenta creada correctamente";

        $this->redirect(base_url('login'));
    }

    public function logout(): void
    {
        $this->authService->logout();

        $this->redirect(base_url('login'));
    }
}