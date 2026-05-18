<?php
require_once "../includes/auth.php";
require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/helpers.php";

$conn = Database::connect();

$bibliotecas = $conn->query("
SELECT *
FROM bibliotecas
ORDER BY nombre_b ASC
");
?>

<h2 class="text-3xl font-bold mb-6">
Crear Reserva
</h2>

<?php mensaje(); ?>

<form id="formReserva" class="bg-white p-6 rounded-2xl shadow-lg max-w-xl">

<label class="font-semibold">Biblioteca</label>

<select
    id="biblioteca"
    required
    class="w-full mb-4 p-3 border rounded-xl"
>

<option value="">
Seleccionar biblioteca
</option>

<?php while ($b = $bibliotecas->fetch_assoc()) { ?>

<option value="<?= $b['id_biblioteca'] ?>">
<?= htmlspecialchars($b['nombre_b']) ?>
</option>

<?php } ?>

</select>

<label class="font-semibold">Sala</label>

<select
    id="sala"
    required
    class="w-full mb-4 p-3 border rounded-xl"
>

<option value="">
Seleccionar sala
</option>

</select>

<label class="font-semibold">Mesa</label>

<select
    name="mesa"
    id="mesa"
    required
    class="w-full mb-4 p-3 border rounded-xl"
>

<option value="">
Seleccionar mesa
</option>

</select>

<label class="font-semibold">Fecha</label>

<input
    type="date"
    name="fecha"
    required
    min="<?= date('Y-m-d') ?>"
    class="w-full mb-4 p-3 border rounded-xl"
>

<label class="font-semibold">Hora inicio</label>

<input
    type="time"
    name="inicio"
    required
    class="w-full mb-4 p-3 border rounded-xl"
>

<label class="font-semibold">Hora fin</label>

<input
    type="time"
    name="fin"
    required
    class="w-full mb-6 p-3 border rounded-xl"
>

<button
    class="
    w-full
    bg-gradient-to-r
    from-blue-500
    to-blue-700
    text-white
    py-3
    rounded-xl
    hover:scale-105
    transition
    shadow-lg
    "
>
Crear reserva
</button>

</form>

<div id="mensajeAjax" class="mt-4"></div>

<script src="../resources/js/reservas.js"></script>

<?php require_once "../includes/footer.php"; ?>