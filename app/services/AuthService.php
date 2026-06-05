<?php

declare(strict_types=1);

require_once "../app/models/Usuario.php";

class AuthService
{
    private Usuario $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel =
            new Usuario();
    }

    // =========================
    // LOGIN
    // =========================

    public function login(
        string $email,
        string $password
    ): bool {

        $usuario =
            $this->usuarioModel
                ->obtenerPorEmail($email);

        if (!$usuario) {

            return false;
        }

        if (
            !password_verify(
                $password,
                $usuario['contrasena']
            )
        ) {

            return false;
        }

        $_SESSION['id'] =
            (int)$usuario['id_usuario'];

        $_SESSION['nombre'] =
            $usuario['nombre_u'];

        $_SESSION['rol'] =
            $usuario['rol'];

        $_SESSION['login_success'] = true;

        return true;
    }

    // =========================
    // REGISTRO
    // =========================

    public function registrar(
        string $nombre,
        string $email,
        string $password
    ): bool {

        $usuarioExistente =
            $this->usuarioModel
                ->obtenerPorEmail($email);

        if ($usuarioExistente) {

            return false;
        }

        $passwordHash =
            password_hash(
                $password,
                PASSWORD_BCRYPT
            );

        return $this->usuarioModel->crear(
            $nombre,
            $email,
            $passwordHash
        );
    }

    // =========================
    // LOGOUT
    // =========================

    public function logout(): void
    {
        $_SESSION = [];

        if (
            ini_get("session.use_cookies")
        ) {

            $params =
                session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }
}