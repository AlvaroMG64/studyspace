<?php

declare(strict_types=1);

/** @var array $reserva */

require_once __DIR__ . "/../layouts/header.php";

?>

<h2 class="text-3xl font-bold mb-6">
    Editar Reserva
</h2>

<form
    id="formEditar"
    class="bg-white p-6 rounded-2xl shadow-lg max-w-xl"
>

    <input
        type="hidden"
        name="id"
        value="<?= $reserva['id_reserva'] ?>"
    >

    <label class="font-semibold">
        Fecha
    </label>

    <input
        type="date"
        name="fecha"
        value="<?= $reserva['fecha_r'] ?>"
        required
        class="w-full mb-4 p-3 border rounded-xl"
    >

    <label class="font-semibold">
        Hora inicio
    </label>

    <input
        type="time"
        name="inicio"
        value="<?= $reserva['hora_inicio'] ?>"
        required
        class="w-full mb-4 p-3 border rounded-xl"
    >

    <label class="font-semibold">
        Hora fin
    </label>

    <input
        type="time"
        name="fin"
        value="<?= $reserva['hora_fin'] ?>"
        required
        class="w-full mb-6 p-3 border rounded-xl"
    >

    <button
        class="
        w-full
        bg-gradient-to-r
        from-blue-500
        to-indigo-600
        text-white
        py-3
        rounded-xl
        hover:scale-105
        transition
        shadow-lg
        "
    >
        Guardar cambios
    </button>

</form>

<div id="mensajeAjax" class="mt-4"></div>

<script src="/studyspace/resources/js/reservas.js"></script>

<?php

require_once __DIR__ . "/../layouts/footer.php";