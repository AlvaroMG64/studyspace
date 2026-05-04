<?php
require_once "../includes/auth.php";
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: crear.php");
    exit;
}

$fecha = $_POST['fecha'];
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$mesa = intval($_POST['mesa']);
$usuario = $_SESSION['id'];

// VALIDACIONES
if (!$fecha || !$inicio || !$fin || !$mesa) {
    $_SESSION['error'] = "Datos incompletos";
    header("Location: crear.php");
    exit;
}

if ($inicio >= $fin) {
    $_SESSION['error'] = "Hora incorrecta";
    header("Location: crear.php");
    exit;
}

if ($fecha < date("Y-m-d")) {
    $_SESSION['error'] = "No puedes reservar en el pasado";
    header("Location: crear.php");
    exit;
}

// VALIDAR MESA
$stmt = $conn->prepare("SELECT id_mesa FROM mesas WHERE id_mesa = ?");
$stmt->bind_param("i", $mesa);
$stmt->execute();

if ($stmt->get_result()->num_rows === 0) {
    $_SESSION['error'] = "Mesa inválida";
    header("Location: crear.php");
    exit;
}

// EVITAR SOLAPAMIENTOS
$stmt = $conn->prepare("
SELECT id_reserva FROM reservas
WHERE id_mesa = ?
AND fecha_r = ?
AND NOT (hora_fin <= ? OR hora_inicio >= ?)
");

$stmt->bind_param("isss", $mesa, $fecha, $inicio, $fin);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    $_SESSION['error'] = "Horario ocupado";
    header("Location: crear.php");
    exit;
}

// INSERT
$stmt = $conn->prepare("
INSERT INTO reservas (fecha_r, hora_inicio, hora_fin, id_usuario, id_mesa)
VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssii", $fecha, $inicio, $fin, $usuario, $mesa);
$stmt->execute();

$_SESSION['success'] = "Reserva creada correctamente";
header("Location: mis_reservas.php");
exit;