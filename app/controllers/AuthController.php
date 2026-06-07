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

    // =========================
    // HOME
    // =========================

    public function home(): void
    {
        $this->requireAuth();

        if (esAdmin()) {

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

    // =========================
    // LOGIN VIEW
    // =========================

    public function login(): void
    {
        $this->view("auth/login");
    }

    // =========================
    // LOGIN POST
    // =========================

    public function autenticar(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {

            $_SESSION['error'] = "Todos los campos son obligatorios";
            $this->redirect("/studyspace/public/login");
        }

        $ok = $this->authService->login($email, $password);

        if (!$ok) {

            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            $this->redirect("/studyspace/public/login");
        }

        // 🔥 UX FLAG (IMPORTANTE)
        $_SESSION['login_success'] = true;

        $this->redirect("/studyspace/public/");
    }

    // =========================
    // REGISTRO VIEW
    // =========================

    public function registro(): void
    {
        $this->view("auth/registro");
    }

    // =========================
    // REGISTRO POST
    // =========================

    public function guardarRegistro(): void
    {
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($nombre) || empty($email) || empty($password)) {

            $_SESSION['error'] = "Todos los campos son obligatorios";
            $this->redirect("/studyspace/public/registro");
        }

        $ok = $this->authService->registrar($nombre, $email, $password);

        if (!$ok) {

            $_SESSION['error'] = "El email ya existe";
            $this->redirect("/studyspace/public/registro");
        }

        // 🔥 UX FLAG
        $_SESSION['success'] = "Cuenta creada correctamente";

        $this->redirect("/studyspace/public/login");
    }

    // =========================
    // LOGOUT
    // =========================

    public function logout(): void
    {
        $this->authService->logout();

        // 🔥 UX FLAG
        $_SESSION['logout_success'] = true;

        $this->redirect("/studyspace/public/login");
    }
}