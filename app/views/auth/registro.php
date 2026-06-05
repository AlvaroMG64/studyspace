<?php

declare(strict_types=1);

require_once "../core/helpers.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>StudySpace - Registro</title>

<script src="https://cdn.tailwindcss.com"></script>

<link
    rel="preconnect"
    href="https://fonts.googleapis.com"
>

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
    rel="stylesheet"
>

<style>

    body {
        font-family: 'Roboto', sans-serif;
    }

    h1,
    h2,
    .font-display {
        font-family: 'Poppins', sans-serif;
    }

</style>

</head>

<body class="bg-gradient-to-br from-green-100 to-emerald-200 min-h-screen flex items-center justify-center p-6">

<div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md">

    <div class="text-center mb-8">

        <h1 class="text-5xl font-bold text-green-700 mb-3 font-display">
            StudySpace
        </h1>

        <p class="text-gray-600 text-lg">
            Crea tu cuenta y empieza a gestionar
            tus reservas de estudio
        </p>

    </div>

    <h2 class="text-3xl font-bold mb-6 text-center font-display">
        Registro
    </h2>

    <?php mensaje(); ?>

    <form method="POST" action="/studyspace/public/registro">

        <input
            type="text"
            name="nombre"
            placeholder="Nombre completo"
            required
            class="w-full p-4 border rounded-2xl mb-4"
        >

        <input
            type="email"
            name="email"
            placeholder="Correo electrónico"
            required
            class="w-full p-4 border rounded-2xl mb-4"
        >

        <input
            type="password"
            name="password"
            placeholder="Contraseña"
            required
            class="w-full p-4 border rounded-2xl mb-6"
        >

        <button
            class="
            w-full
            bg-gradient-to-r
            from-green-600
            to-emerald-700
            text-white
            py-4
            rounded-2xl
            font-semibold
            text-lg
            shadow-lg
            "
        >
            Crear cuenta
        </button>

    </form>

    <p class="mt-6 text-center text-gray-600">

        ¿Ya tienes cuenta?

        <a
            href="/studyspace/public/login"
            class="text-green-700 font-semibold"
        >
            Inicia sesión
        </a>

    </p>

</div>

</body>
</html>