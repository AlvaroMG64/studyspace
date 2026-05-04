<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>StudySpace</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<nav class="bg-blue-600 text-white p-4 flex justify-between items-center shadow">

    <h1 class="text-xl font-bold">📚 StudySpace</h1>

    <div class="flex items-center gap-4">

        <span class="font-medium">
            <?= htmlspecialchars($_SESSION['nombre'] ?? '') ?>
        </span>

        <a href="../auth/logout.php"
           class="bg-red-500 px-3 py-1 rounded hover:bg-red-600 transition">
           Salir
        </a>

    </div>

</nav>

<div class="p-6">