<?php

declare(strict_types=1);

/** @var mysqli_result $bibliotecas */

require_once "../app/views/layouts/header.php";

?>

<div class="flex justify-center">

    <div class="w-full max-w-6xl">

        <h2 class="text-4xl font-bold mb-8 text-center font-display">
            Crear Reserva
        </h2>

        <form
            id="formReserva"
            class="bg-white p-10 rounded-3xl shadow-xl"
        >

            <div
                id="mensajeAjax"
                class="mb-6"
            ></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- BIBLIOTECA -->

                <div>

                    <label class="font-semibold block mb-2">
                        Biblioteca
                    </label>

                    <select
                        id="biblioteca"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                        <option value="">
                            Seleccionar biblioteca
                        </option>

                        <?php while ($b = $bibliotecas->fetch_assoc()) : ?>

                            <option value="<?= (int)$b['id_biblioteca'] ?>">

                                <?= htmlspecialchars($b['nombre_b']) ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <!-- SALA -->

                <div>

                    <label class="font-semibold block mb-2">
                        Sala
                    </label>

                    <select
                        id="sala"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                        <option value="">
                            Seleccionar sala
                        </option>

                    </select>

                </div>

                <!-- MESA -->

                <div>

                    <label class="font-semibold block mb-2">
                        Mesa
                    </label>

                    <select
                        name="mesa"
                        id="mesa"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                        <option value="">
                            Seleccionar mesa
                        </option>

                    </select>

                </div>

                <!-- FECHA -->

                <div>

                    <label class="font-semibold block mb-2">
                        Fecha
                    </label>

                    <input
                        type="date"
                        name="fecha"
                        min="<?= date('Y-m-d') ?>"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                </div>

                <!-- HORA INICIO -->

                <div>

                    <label class="font-semibold block mb-2">
                        Hora inicio
                    </label>

                    <input
                        type="time"
                        name="inicio"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                </div>

                <!-- HORA FIN -->

                <div>

                    <label class="font-semibold block mb-2">
                        Hora fin
                    </label>

                    <input
                        type="time"
                        name="fin"
                        required
                        class="w-full p-3 border rounded-xl"
                    >

                </div>

            </div>

            <button
                class="
                mt-10
                w-full
                bg-gradient-to-r
                from-blue-500
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
                Crear reserva
            </button>

        </form>

    </div>

</div>

<script src="/studyspace/resources/js/reservas.js"></script>

<?php

require_once "../app/views/layouts/footer.php";
?>