<?php

declare(strict_types=1);

require_once "../app/models/Reserva.php";

class ReservaService {

    private Reserva $reservaModel;

    public function __construct()
    {
        $this->reservaModel =
            new Reserva();
    }

    // =========================
    // CREAR RESERVA
    // =========================

    public function crearReserva(
        string $fecha,
        string $inicio,
        string $fin,
        int $usuario,
        int $mesa
    ): array {

        // VALIDAR CAMPOS

        if (
            !$fecha ||
            !$inicio ||
            !$fin ||
            !$mesa
        ) {

            return [
                "success" => false,
                "message" =>
                    "Todos los campos son obligatorios"
            ];
        }

        // VALIDAR FECHA

        if ($fecha < date("Y-m-d")) {

            return [
                "success" => false,
                "message" =>
                    "No se pueden realizar reservas en fechas pasadas"
            ];
        }

        // VALIDAR HORARIO

        if ($inicio >= $fin) {

            return [
                "success" => false,
                "message" =>
                    "La fecha de fin debe ser posterior a la de inicio"
            ];
        }

        // VALIDAR MESA

        if (
            $this->reservaModel
                ->existeSolapamientoMesa(
                    $mesa,
                    $fecha,
                    $inicio,
                    $fin
                )
        ) {

            return [
                "success" => false,
                "message" =>
                    "La mesa ya está ocupada"
            ];
        }

        // VALIDAR USUARIO

        if (
            $this->reservaModel
                ->existeSolapamientoUsuario(
                    $usuario,
                    $fecha,
                    $inicio,
                    $fin
                )
        ) {

            return [
                "success" => false,
                "message" =>
                    "Ya tienes una reserva en ese horario"
            ];
        }

        // CREAR

        $ok =
            $this->reservaModel
                ->crear(
                    $fecha,
                    $inicio,
                    $fin,
                    $usuario,
                    $mesa
                );

        return [
            "success" => $ok
        ];
    }

    // =========================
    // ACTUALIZAR RESERVA
    // =========================

    public function actualizarReserva(
        int $id,
        string $fecha,
        string $inicio,
        string $fin,
        int $mesa,
        int $usuario,
        string $rol
    ): array {

        // VALIDAR CAMPOS

        if (
            !$id ||
            !$fecha ||
            !$inicio ||
            !$fin ||
            !$mesa
        ) {

            return [
                "success" => false,
                "message" =>
                    "Todos los campos son obligatorios"
            ];
        }

        // VALIDAR FECHA

        if ($fecha < date("Y-m-d")) {

            return [
                "success" => false,
                "message" =>
                    "No se pueden realizar reservas en fechas pasadas"
            ];
        }

        // VALIDAR HORARIO

        if ($inicio >= $fin) {

            return [
                "success" => false,
                "message" =>
                    "La fecha de fin debe ser posterior a la de inicio"
            ];
        }

        // VALIDAR RESERVA

        $reserva =
            $this->reservaModel
                ->obtenerPorId($id);

        if (!$reserva) {

            return [
                "success" => false,
                "message" =>
                    "Reserva no encontrada"
            ];
        }

        // VALIDAR PERMISOS

        if (
            $rol !== 'admin'
            && $reserva['id_usuario'] != $usuario
        ) {

            return [
                "success" => false,
                "message" =>
                    "No autorizado"
            ];
        }

        // VALIDAR SOLAPAMIENTO MESA

        if (
            $this->reservaModel
                ->existeSolapamientoMesa(
                    $mesa,
                    $fecha,
                    $inicio,
                    $fin,
                    $id
                )
        ) {

            return [
                "success" => false,
                "message" =>
                    "La mesa ya está ocupada"
            ];
        }

        // VALIDAR SOLAPAMIENTO USUARIO

        if (
            $this->reservaModel
                ->existeSolapamientoUsuario(
                    $usuario,
                    $fecha,
                    $inicio,
                    $fin,
                    $id
                )
        ) {

            return [
                "success" => false,
                "message" =>
                    "Ya tienes una reserva en ese horario"
            ];
        }

        // ACTUALIZAR

        $ok =
            $this->reservaModel
                ->actualizar(
                    $id,
                    $fecha,
                    $inicio,
                    $fin,
                    $mesa
                );

        if (!$ok) {

            return [
                "success" => false,
                "message" =>
                    "Error actualizando reserva"
            ];
        }

        return [
            "success" => true
        ];
    }

    // =========================
    // ELIMINAR RESERVA
    // =========================

    public function eliminarReserva(
        int $id,
        int $usuario,
        string $rol
    ): array {

        // VALIDAR RESERVA

        $reserva =
            $this->reservaModel
                ->obtenerPorId($id);

        if (!$reserva) {

            return [
                "success" => false,
                "message" =>
                    "Reserva no encontrada"
            ];
        }

        // VALIDAR PERMISOS

        if (
            $rol !== 'admin'
            && $reserva['id_usuario'] != $usuario
        ) {

            return [
                "success" => false,
                "message" =>
                    "No autorizado"
            ];
        }

        // ELIMINAR

        $ok =
            $this->reservaModel
                ->eliminar($id);

        return [
            "success" => $ok
        ];
    }

    // =========================
    // RESERVAS USUARIO
    // =========================

    public function obtenerReservasUsuario(
        int $usuario
    ): mysqli_result {

        return $this->reservaModel
            ->obtenerPorUsuario(
                $usuario
            );
    }

    // =========================
    // RESERVA POR ID
    // =========================

    public function obtenerReserva(
        int $id
    ): ?array {

        return $this->reservaModel
            ->obtenerPorId($id);
    }

    // =========================
    // VALIDAR ACCESO
    // =========================

    public function puedeGestionarReserva(
        array $reserva,
        int $usuario,
        string $rol
    ): bool {

        return
            $rol === 'admin'
            || $reserva['id_usuario'] == $usuario;
    }
}