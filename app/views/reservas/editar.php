<?php

declare(strict_types=1);

/** @var array $reserva */

require_once "../app/views/layouts/header.php";

?>

<div class="flex justify-center">

    <div class="w-full max-w-3xl">

        <h2 class="text-4xl font-bold mb-8 text-center">
            Editar Reserva
        </h2>

        <form
            id="formEditar"
            class="bg-white p-8 rounded-3xl shadow-xl"
        >

            <div
                id="mensajeAjax"
                class="mb-6"
            ></div>

            <input
                type="hidden"
                name="id"
                value="<?= (int)$reserva['id_reserva'] ?>"
            >

            <input
                type="hidden"
                name="mesa"
                value="<?= (int)$reserva['id_mesa'] ?>"
            >

            <div class="bg-blue-50 border border-blue-200 p-5 rounded-2xl mb-8">

                <p class="mb-2">
                    <span class="font-semibold">Biblioteca:</span>
                    <?= htmlspecialchars($reserva['nombre_b']) ?>
                </p>

                <p class="mb-2">
                    <span class="font-semibold">Sala:</span>
                    <?= htmlspecialchars($reserva['nombre_s']) ?>
                </p>

                <p>
                    <span class="font-semibold">Mesa:</span>
                    <?= (int)$reserva['numero'] ?>
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="font-semibold block mb-2">
                        Fecha
                    </label>

                    <input
                        type="date"
                        name="fecha"
                        value="<?= htmlspecialchars($reserva['fecha_r']) ?>"
                        min="<?= date('Y-m-d') ?>"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                </div>

                <div>

                    <label class="font-semibold block mb-2">
                        Hora inicio
                    </label>

                    <input
                        type="time"
                        name="inicio"
                        value="<?= substr($reserva['hora_inicio'], 0, 5) ?>"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                </div>

                <div>

                    <label class="font-semibold block mb-2">
                        Hora fin
                    </label>

                    <input
                        type="time"
                        name="fin"
                        value="<?= substr($reserva['hora_fin'], 0, 5) ?>"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                </div>

            </div>

            <button
                class="
                mt-8
                w-full
                bg-gradient-to-r
                from-indigo-500
                to-blue-700
                text-white
                py-4
                rounded-2xl
                hover:scale-[1.01]
                transition
                shadow-lg
                font-semibold
                text-lg
                "
            >
                Guardar cambios
            </button>

        </form>

    </div>

</div>

<script src="/studyspace/resources/js/reservas.js"></script>

<?php

require_once "../app/views/layouts/footer.php";
?>