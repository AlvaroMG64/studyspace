<?php

declare(strict_types=1);

require_once "../core/Controller.php";

require_once "../app/models/Usuario.php";
require_once "../app/models/Reserva.php";

class AuthController extends Controller {

    // =========================
    // HOME
    // =========================

    public function home(): void
    {
        if (!isset($_SESSION['id'])) {

            header(
                "Location: /studyspace/public/login"
            );

            exit;
        }

        // =========================
        // ADMIN
        // =========================

        if (esAdmin()) {

            $reservaModel =
                new Reserva();

            $reservas =
                $reservaModel
                    ->obtenerTodas()
                    ->fetch_all(MYSQLI_ASSOC);

            $this->view(
                "dashboard/admin",
                [
                    "reservas" => $reservas
                ]
            );

            return;
        }

        // =========================
        // USER
        // =========================

        $this->view(
            "dashboard/user"
        );
    }

    // =========================
    // LOGIN VIEW
    // =========================

    public function login(): void
    {
        $this->view("auth/login");
    }

    // =========================
    // LOGIN
    // =========================

    public function autenticar(): void
    {
        $email =
            trim($_POST['email'] ?? '');

        $password =
            trim($_POST['password'] ?? '');

        if (
            empty($email)
            || empty($password)
        ) {

            $_SESSION['error'] =
                "Todos los campos son obligatorios";

            header(
                "Location: /studyspace/public/login"
            );

            exit;
        }

        $usuarioModel =
            new Usuario();

        $usuario =
            $usuarioModel
                ->obtenerPorEmail($email);

        if (
            !$usuario
            || !password_verify(
                $password,
                $usuario['contrasena']
            )
        ) {

            $_SESSION['error'] =
                "Credenciales incorrectas";

            header(
                "Location: /studyspace/public/login"
            );

            exit;
        }

        $_SESSION['id'] =
            $usuario['id_usuario'];

        $_SESSION['nombre'] =
            $usuario['nombre_u'];

        $_SESSION['rol'] =
            $usuario['rol'];

        $_SESSION['success'] =
            "Bienvenido "
            . $usuario['nombre_u']
            . " ("
            . $usuario['rol']
            . ")";

        header(
            "Location: /studyspace/public/"
        );

        exit;
    }

    // =========================
    // REGISTRO VIEW
    // =========================

    public function registro(): void
    {
        $this->view("auth/registro");
    }

    // =========================
    // REGISTRO
    // =========================

    public function guardarRegistro(): void
    {
        $nombre =
            trim($_POST['nombre'] ?? '');

        $email =
            trim($_POST['email'] ?? '');

        $password =
            trim($_POST['password'] ?? '');

        if (
            empty($nombre)
            || empty($email)
            || empty($password)
        ) {

            $_SESSION['error'] =
                "Todos los campos son obligatorios";

            header(
                "Location: /studyspace/public/registro"
            );

            exit;
        }

        $usuarioModel =
            new Usuario();

        if (
            $usuarioModel
                ->obtenerPorEmail($email)
        ) {

            $_SESSION['error'] =
                "El email ya existe";

            header(
                "Location: /studyspace/public/registro"
            );

            exit;
        }

        $usuarioModel->crear(
            $nombre,
            $email,
            $password
        );

        $_SESSION['success'] =
            "Cuenta creada correctamente";

        header(
            "Location: /studyspace/public/login"
        );

        exit;
    }

    // =========================
    // LOGOUT
    // =========================

    public function logout(): void
    {
        $_SESSION = [];

        session_destroy();

        echo '
        <!DOCTYPE html>
        <html lang="es">

        <head>

            <meta charset="UTF-8">

            <title>Cerrando sesión</title>

            <script src="https://cdn.tailwindcss.com"></script>

            <link
                href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
                rel="stylesheet"
            >

            <style>

                body {
                    font-family: Roboto, sans-serif;
                }

                h1 {
                    font-family: Poppins, sans-serif;
                }

            </style>

        </head>

        <body class="
            bg-black/40
            min-h-screen
            flex
            items-center
            justify-center
        ">

            <div class="
                bg-white
                p-10
                rounded-3xl
                shadow-2xl
                text-center
                max-w-md
                w-full
            ">

                <h1 class="
                    text-3xl
                    font-bold
                    text-red-600
                    mb-4
                ">
                    Sesión cerrada
                </h1>

                <p class="
                    text-gray-600
                    mb-6
                ">
                    Cerrando sesión...
                </p>

                <div class="
                    w-full
                    bg-gray-200
                    rounded-full
                    h-3
                    overflow-hidden
                ">

                    <div class="
                        bg-red-600
                        h-3
                        animate-pulse
                    "></div>

                </div>

            </div>

            <script>

                setTimeout(() => {

                    window.location.href =
                        "/studyspace/public/login";

                }, 1800);

            </script>

        </body>
        </html>
        ';
    }
}