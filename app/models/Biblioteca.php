<?php

declare(strict_types=1);

require_once "../core/Model.php";

class Biblioteca extends Model
{
    // =========================
    // OBTENER TODAS
    // =========================

    public function obtenerTodas(): mysqli_result
    {
        $sql = "
            SELECT *
            FROM bibliotecas
            ORDER BY nombre_b ASC
        ";

        return $this->db->query($sql);
    }
}