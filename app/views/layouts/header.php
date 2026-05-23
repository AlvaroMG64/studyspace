<?php

declare(strict_types=1);

if (!isset($_SESSION['id'])) {

    header("Location: /studyspace/public/login");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>StudySpace</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-700 text-white p-4 shadow-lg">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-2xl font-bold">
            StudySpace
        </h1>

        <div class="flex gap-6 items-center">

            <a
                href="/studyspace/public/"
                class="hover:underline"
            >
                Inicio
            </a>

            <a
                href="/studyspace/public/mis-reservas"
                class="hover:underline"
            >
                Mis reservas
            </a>

            <a
                href="/studyspace/public/crear-reserva"
                class="hover:underline"
            >
                Crear reserva
            </a>

            <a
                href="/studyspace/public/logout"
                class="bg-red-500 px-4 py-2 rounded-xl hover:bg-red-600 transition"
            >
                Salir
            </a>

        </div>

    </div>

</nav>

<main class="max-w-7xl mx-auto p-6">