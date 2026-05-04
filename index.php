<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: auth/login.php");
    exit;
}

if ($_SESSION['rol'] === 'admin') {
    header("Location: dashboard/admin.php");
} else {
    header("Location: dashboard/usuario.php");
}