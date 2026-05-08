<?php
session_start();
require_once "../config/database.php";

header("Content-Type: application/json");

$conn = Database::connect();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
    exit;
}

$fecha = $_POST['fecha'] ?? '';
$inicio = $_POST['inicio'] ?? '';
$fin = $_POST['fin'] ?? '';
$mesa = intval($_POST['mesa'] ?? 0);
$usuario = $_SESSION['id'] ?? null;

// Validaciones
if (!$fecha || !$inicio || !$fin || !$mesa) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

if ($inicio >= $fin) {
    echo json_encode(["success" => false, "message" => "Hora incorrecta"]);
    exit;
}

if ($fecha < date("Y-m-d")) {
    echo json_encode(["success" => false, "message" => "Fecha inválida"]);
    exit;
}

// Solapamiento
$stmt = $conn->prepare("
SELECT id_reserva FROM reservas
WHERE id_mesa = ?
AND fecha_r = ?
AND NOT (hora_fin <= ? OR hora_inicio >= ?)
");

$stmt->bind_param("isss", $mesa, $fecha, $inicio, $fin);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Horario ocupado"]);
    exit;
}

// Insert
$stmt = $conn->prepare("
INSERT INTO reservas (fecha_r, hora_inicio, hora_fin, id_usuario, id_mesa)
VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssii", $fecha, $inicio, $fin, $usuario, $mesa);
$stmt->execute();

echo json_encode([
    "success" => true,
    "message" => "Reserva creada correctamente"
]);