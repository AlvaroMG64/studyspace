<?php

declare(strict_types=1);

require_once "../core/Model.php";

class Mesa extends Model
{
    public function obtenerPorSala(int $sala): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM mesas
            WHERE id_sala = ?
            ORDER BY numero ASC
        ");

        $stmt->bind_param("i", $sala);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}