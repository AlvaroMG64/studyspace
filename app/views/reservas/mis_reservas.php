<?php

declare(strict_types=1);

/** @var mysqli_result $reservas */

require_once "../app/views/layouts/header.php";

?>

<h2 class="text-4xl font-bold mb-8 font-display">
    Mis Reservas
</h2>

<div
    id="mensajeAjax"
    class="mb-6"
></div>

<?php if ($reservas->num_rows > 0) : ?>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        <?php while ($r = $reservas->fetch_assoc()) : ?>

            <div
                id="fila-<?= (int)$r['id_reserva'] ?>"
                class="bg-white rounded-3xl shadow-xl p-6"
            >

                <div class="flex justify-between items-start mb-5">

                    <div>

                        <h3 class="text-2xl font-bold font-display">

                            Mesa <?= (int)$r['numero'] ?>

                        </h3>

                        <p class="text-gray-500">
                            <?= htmlspecialchars($r['nombre_s']) ?>
                        </p>

                    </div>

                    <span class="
                        bg-blue-100
                        text-blue-700
                        px-4
                        py-2
                        rounded-xl
                        text-sm
                        font-medium
                    ">
                        <?= htmlspecialchars($r['fecha_r']) ?>
                    </span>

                </div>

                <div class="space-y-3 text-gray-700">

                    <p>

                        <span class="font-semibold">
                            Biblioteca:
                        </span>

                        <?= htmlspecialchars($r['nombre_b']) ?>

                    </p>

                    <p>

                        <span class="font-semibold">
                            Horario:
                        </span>

                        <?= substr($r['hora_inicio'], 0, 5) ?>

                        -

                        <?= substr($r['hora_fin'], 0, 5) ?>

                    </p>

                </div>

                <div class="flex gap-4 mt-8">

                    <a
                        href="/studyspace/public/editar-reserva?id=<?= (int)$r['id_reserva'] ?>"
                        class="
                        flex-1
                        text-center
                        bg-blue-600
                        text-white
                        py-3
                        rounded-2xl
                        font-medium
                        "
                    >
                        Editar
                    </a>

                    <button
                        class="
                        flex-1
                        bg-red-500
                        text-white
                        py-3
                        rounded-2xl
                        font-medium
                        btnEliminar
                        "
                        data-id="<?= (int)$r['id_reserva'] ?>"
                    >
                        Eliminar
                    </button>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

<?php else : ?>

    <div class="bg-white p-10 rounded-3xl shadow-xl text-center">

        <h3 class="text-2xl font-bold mb-3 font-display">
            No tienes reservas
        </h3>

        <p class="text-gray-600">
            Todavía no has realizado ninguna reserva.
        </p>

    </div>

<?php endif; ?>

<script src="/studyspace/resources/js/reservas.js"></script>

<?php

require_once "../app/views/layouts/footer.php";
?>