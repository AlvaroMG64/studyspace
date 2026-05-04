<?php
require_once "../includes/auth.php";
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: mis_reservas.php");
    exit;
}

$id = intval($_POST['id']);
$fecha = $_POST['fecha'];
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$usuario = $_SESSION['id'];

if (!$fecha || !$inicio || !$fin) {
    $_SESSION['error'] = "Datos incompletos";
    header("Location: editar.php?id=$id");
    exit;
}

if ($inicio >= $fin) {
    $_SESSION['error'] = "Hora incorrecta";
    header("Location: editar.php?id=$id");
    exit;
}

if ($fecha < date("Y-m-d")) {
    $_SESSION['error'] = "No puedes reservar en el pasado";
    header("Location: editar.php?id=$id");
    exit;
}

// Obtener reserva
$stmt = $conn->prepare("SELECT * FROM reservas WHERE id_reserva = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$reserva = $stmt->get_result()->fetch_assoc();

if (!$reserva) {
    die("No existe");
}

if ($reserva['id_usuario'] != $usuario && !esAdmin()) {
    die("No autorizado");
}

// Evitar solapamientos
$stmt = $conn->prepare("
SELECT id_reserva FROM reservas
WHERE id_mesa = ?
AND fecha_r = ?
AND id_reserva != ?
AND NOT (hora_fin <= ? OR hora_inicio >= ?)
");

$stmt->bind_param("isiss", $reserva['id_mesa'], $fecha, $id, $inicio, $fin);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    $_SESSION['error'] = "Horario ocupado";
    header("Location: editar.php?id=$id");
    exit;
}

// Update
$stmt = $conn->prepare("
UPDATE reservas 
SET fecha_r=?, hora_inicio=?, hora_fin=? 
WHERE id_reserva=?
");

$stmt->bind_param("sssi", $fecha, $inicio, $fin, $id);
$stmt->execute();

$_SESSION['success'] = "Reserva actualizada";
header("Location: mis_reservas.php");
exit;