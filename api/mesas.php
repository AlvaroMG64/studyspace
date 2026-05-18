<?php

require_once "../config/database.php";

header("Content-Type: application/json");

$conn = Database::connect();

$idSala = intval($_GET['sala'] ?? 0);

$stmt = $conn->prepare("
SELECT
    id_mesa,
    numero
FROM mesas
WHERE id_sala = ?
ORDER BY numero ASC
");

$stmt->bind_param("i", $idSala);
$stmt->execute();

$result = $stmt->get_result();

$mesas = [];

while ($row = $result->fetch_assoc()) {
    $mesas[] = $row;
}

echo json_encode($mesas);