<?php

declare(strict_types=1);

require_once "../app/views/layouts/header.php";
?>

<h1 class="text-4xl font-bold mb-6 font-display">

    Bienvenido,
    <?= htmlspecialchars($_SESSION['nombre']) ?>

</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <a
        href="/studyspace/public/crear-reserva"
        class="bg-white p-8 rounded-3xl shadow-lg hover:scale-105 transition block"
    >

        <h2 class="text-2xl font-bold mb-2">
            Crear reserva
        </h2>

        <p class="text-gray-600">
            Reserva una mesa de estudio
        </p>

    </a>

    <a
        href="/studyspace/public/mis-reservas"
        class="bg-white p-8 rounded-3xl shadow-lg hover:scale-105 transition block"
    >

        <h2 class="text-2xl font-bold mb-2">
            Mis reservas
        </h2>

        <p class="text-gray-600">
            Gestiona tus reservas actuales
        </p>

    </a>

</div>

<!-- TREE -->

<div class="bg-white p-8 rounded-3xl shadow-lg">

    <h2 class="text-3xl font-bold mb-6 font-display">
        Bibliotecas y salas disponibles
    </h2>

    <div
        id="studyspaceTree"
        class="grid grid-cols-1 lg:grid-cols-2 gap-6"
    >

        <p class="text-gray-500">
            Cargando estructura...
        </p>

    </div>

</div>

<script src="/studyspace/resources/js/dashboard.js"></script>

<?php
require_once "../app/views/layouts/footer.php";
?>