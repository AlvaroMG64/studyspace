<?php

require_once "../app/models/Usuario.php";

class AuthController extends Controller {

    // LOGIN VIEW
    public function login() {

        $this->view("auth/login");
    }

    // REGISTRO VIEW
    public function registro() {

        $this->view("auth/registro");
    }

    // LOGIN POST
    public function autenticar() {

        $email = filter_var(
            trim($_POST['email']),
            FILTER_SANITIZE_EMAIL
        );

        $password = trim($_POST['password']);

        if (!$email || !$password) {

            $_SESSION['error'] =
                "Debes completar todos los campos";

            header("Location: /studyspace/public/login");
            exit;
        }

        $usuarioModel = new Usuario();

        $usuario = $usuarioModel
            ->obtenerPorEmail($email);

        if (
            !$usuario ||
            !password_verify(
                $password,
                $usuario['contrasena']
            )
        ) {

            $_SESSION['error'] =
                "Correo o contraseña incorrectos";

            header("Location: /studyspace/public/login");
            exit;
        }

        $_SESSION['id'] =
            $usuario['id_usuario'];

        $_SESSION['nombre'] =
            $usuario['nombre_u'];

        $_SESSION['rol'] =
            $usuario['rol'];

        header("Location: /studyspace/public/");
        exit;
    }

    // REGISTRO POST
    public function guardarRegistro() {

        $nombre = htmlspecialchars(
            trim($_POST['nombre'])
        );

        $email = filter_var(
            trim($_POST['email']),
            FILTER_SANITIZE_EMAIL
        );

        $password = trim($_POST['password']);

        if (
            !$nombre ||
            !$email ||
            !$password
        ) {

            $_SESSION['error'] =
                "Todos los campos son obligatorios";

            header("Location: /studyspace/public/registro");
            exit;
        }

        if (strlen($nombre) < 3) {

            $_SESSION['error'] =
                "El nombre debe tener mínimo 3 caracteres";

            header("Location: /studyspace/public/registro");
            exit;
        }

        if (
            strlen($password) < 8 ||
            !preg_match("/[A-Za-z]/", $password) ||
            !preg_match("/[0-9]/", $password)
        ) {

            $_SESSION['error'] =
                "La contraseña debe tener mínimo 8 caracteres, letras y números";

            header("Location: /studyspace/public/registro");
            exit;
        }

        $usuarioModel = new Usuario();

        if (
            $usuarioModel->obtenerPorEmail($email)
        ) {

            $_SESSION['error'] =
                "El email ya está registrado";

            header("Location: /studyspace/public/registro");
            exit;
        }

        $usuarioModel->crear(
            $nombre,
            $email,
            $password
        );

        $_SESSION['success'] =
            "Cuenta creada correctamente";

        header("Location: /studyspace/public/login");
        exit;
    }

    // LOGOUT
    public function logout() {

        session_destroy();

        header("Location: /studyspace/public/login");
        exit;
    }

    public function home() {

        if (!isset($_SESSION['id'])) {

            header("Location: /studyspace/public/login");
            exit;
        }

        echo "
        <h1>Bienvenido, " .
        htmlspecialchars($_SESSION['nombre']) .
        "</h1>

        <a href='/studyspace/public/logout'>
            Cerrar sesión
        </a>
        ";
    }
}