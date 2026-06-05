<?php

declare(strict_types=1);

require_once "../core/Model.php";

class Estadistica extends Model
{
    // =========================
    // STATS DASHBOARD
    // =========================

    public function obtenerStats(): array
    {
        $stats = [];

        // TOTAL RESERVAS

        $result =
            $this->db->query("
                SELECT COUNT(*) total
                FROM reservas
            ");

        $stats['reservas'] =
            $result->fetch_assoc()['total'];

        // TOTAL USUARIOS

        $result =
            $this->db->query("
                SELECT COUNT(*) total
                FROM usuarios
            ");

        $stats['usuarios'] =
            $result->fetch_assoc()['total'];

        // TOTAL MESAS

        $result =
            $this->db->query("
                SELECT COUNT(*) total
                FROM mesas
            ");

        $stats['mesas'] =
            $result->fetch_assoc()['total'];

        // RESERVAS HOY

        $result =
            $this->db->query("
                SELECT COUNT(*) total
                FROM reservas
                WHERE fecha_r = CURDATE()
            ");

        $stats['hoy'] =
            $result->fetch_assoc()['total'];

        return $stats;
    }
}