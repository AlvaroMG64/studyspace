<?php require_once "../core/helpers.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>StudySpace - Login</title>

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

<body class="bg-gradient-to-br from-blue-100 to-blue-200 min-h-screen flex items-center justify-center p-6">

<div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md">

    <div class="text-center mb-8">

        <h1 class="text-5xl font-bold text-blue-700 mb-3 font-display">
            StudySpace
        </h1>

        <p class="text-gray-600 text-lg">
            Plataforma de gestión de reservas
            de bibliotecas y salas de estudio
        </p>

    </div>

    <h2 class="text-3xl font-bold mb-6 text-center font-display">
        Iniciar sesión
    </h2>

    <?php mensaje(); ?>

    <form method="POST" action="/studyspace/public/login">

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
            from-blue-600
            to-blue-800
            text-white
            py-4
            rounded-2xl
            font-semibold
            text-lg
            shadow-lg
            "
        >
            Entrar
        </button>

    </form>

    <p class="mt-6 text-center text-gray-600">

        ¿No tienes cuenta?

        <a
            href="/studyspace/public/registro"
            class="text-blue-600 font-semibold"
        >
            Regístrate
        </a>

    </p>

</div>

</body>
</html>