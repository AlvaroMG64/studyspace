<?php
declare(strict_types=1);
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StudySpace</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Roboto', sans-serif; }
        h1,h2,h3,h4,.font-display { font-family: 'Poppins', sans-serif; }
    </style>

</head>

<body class="bg-gray-100 min-h-screen">

<?php if (isset($_SESSION['id'])) : ?>

<nav class="bg-blue-700 text-white p-4 shadow-lg">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-2xl font-bold font-display">StudySpace</h1>

        <div class="flex gap-6 items-center">

            <a href="/studyspace/public/">Inicio</a>
            <a href="/studyspace/public/mis-reservas">Mis reservas</a>
            <a href="/studyspace/public/crear-reserva">Crear reserva</a>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') : ?>
                <a href="/studyspace/public/admin">Panel admin</a>
            <?php endif; ?>

            <a href="/studyspace/public/logout"
               onclick="return confirmarLogout(event)"
               class="bg-red-500 px-4 py-2 rounded-xl">
                Salir
            </a>

        </div>

    </div>

</nav>

<?php endif; ?>

<!-- LOGIN SUCCESS -->
<?php if (!empty($_SESSION['login_success'])) : ?>

<div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white p-10 rounded-3xl shadow-2xl text-center max-w-md w-full">

        <h2 class="text-3xl font-bold mb-3">Bienvenido</h2>

        <p class="text-lg mb-2">
            <?= htmlspecialchars($_SESSION['nombre']) ?>
        </p>

        <p class="text-gray-500">
            Rol: <?= $_SESSION['rol'] === 'admin' ? 'Administrador' : 'Usuario' ?>
        </p>

    </div>
</div>

<script>
setTimeout(() => {
    document.querySelector(".fixed.inset-0")?.remove();
}, 2200);
</script>

<?php unset($_SESSION['login_success']); ?>
<?php endif; ?>

<main class="max-w-7xl mx-auto p-6">