<?php
session_start();
require_once "../config/db.php";

$nombre = htmlspecialchars(trim($_POST['nombre']));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = trim($_POST['password']);

// Validaciones básicas
if (!$nombre || !$email || !$password) {
    $_SESSION['error'] = "Todos los campos son obligatorios";
    header("Location: registro.php");
    exit;
}

if (strlen($nombre) < 3) {
    $_SESSION['error'] = "Nombre demasiado corto";
    header("Location: registro.php");
    exit;
}

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Email no válido";
    header("Location: registro.php");
    exit;
}

// Validar contraseña segura
if (strlen($password) < 8 || 
    !preg_match("/[A-Za-z]/", $password) || 
    !preg_match("/[0-9]/", $password)) {

    $_SESSION['error'] = "La contraseña debe tener mínimo 8 caracteres, letras y números";
    header("Location: registro.php");
    exit;
}

// Comprobar email existente
$stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    $_SESSION['error'] = "El email ya está registrado";
    header("Location: registro.php");
    exit;
}

// Encriptar contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario
$stmt = $conn->prepare("
INSERT INTO usuarios (nombre_u, email, contrasena)
VALUES (?, ?, ?)
");

$stmt->bind_param("sss", $nombre, $email, $hash);
$stmt->execute();

$_SESSION['success'] = "Usuario registrado correctamente";
header("Location: login.php");
exit;