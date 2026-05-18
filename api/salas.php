<?php

require_once "../config/database.php";

header("Content-Type: application/json");

$conn = Database::connect();

$idBiblioteca = intval($_GET['biblioteca'] ?? 0);

$stmt = $conn->prepare("
SELECT
    id_sala,
    nombre_s
FROM salas
WHERE id_biblioteca = ?
ORDER BY nombre_s ASC
");

$stmt->bind_param("i", $idBiblioteca);
$stmt->execute();

$result = $stmt->get_result();

$salas = [];

while ($row = $result->fetch_assoc()) {
    $salas[] = $row;
}

echo json_encode($salas);