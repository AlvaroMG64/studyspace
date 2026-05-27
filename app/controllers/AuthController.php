<?php

require_once "../app/models/Usuario.php";

class AuthController extends Controller {

    public function login() {
        $this->view("auth/login");
    }

    public function registro() {
        $this->view("auth/registro");
    }

    public function autenticar() {

        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        if (!$email || !$password) {
            $_SESSION['error'] = "Completa todos los campos";
            header("Location: /studyspace/public/login");
            exit;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->obtenerPorEmail($email);

        if (!$usuario || !password_verify($password, $usuario['contrasena'])) {
            $_SESSION['error'] = "Credenciales incorrectas";
            header("Location: /studyspace/public/login");
            exit;
        }

        $_SESSION['id'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre_u'];
        $_SESSION['rol'] = $usuario['rol'];

        header("Location: /studyspace/public/");
        exit;
    }

    public function guardarRegistro() {

        $nombre = htmlspecialchars(trim($_POST['nombre']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        if (!$nombre || !$email || !$password) {
            $_SESSION['error'] = "Todos los campos son obligatorios";
            header("Location: /studyspace/public/registro");
            exit;
        }

        $usuarioModel = new Usuario();

        if ($usuarioModel->obtenerPorEmail($email)) {
            $_SESSION['error'] = "Email ya registrado";
            header("Location: /studyspace/public/registro");
            exit;
        }

        $usuarioModel->crear($nombre, $email, $password);

        $_SESSION['success'] = "Cuenta creada correctamente";

        header("Location: /studyspace/public/login");
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: /studyspace/public/login");
        exit;
    }

    // 🔥 FIX PRINCIPAL
    public function home() {

        if (!isset($_SESSION['id'])) {
            header("Location: /studyspace/public/login");
            exit;
        }

        if ($_SESSION['rol'] === 'admin') {
            $this->view("dashboard/admin");
        } else {
            $this->view("dashboard/usuario");
        }
    }
}