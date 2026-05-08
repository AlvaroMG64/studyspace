<?php
require_once "../includes/auth.php";
require_once "../includes/header.php";
require_once "../config/db.php";
require_once "../includes/helpers.php";

$mesas = $conn->query("SELECT * FROM mesas");
?>

<h2 class="text-2xl font-bold mb-4">Crear Reserva</h2>

<?php mensaje(); ?>

<!-- IMPORTANTE: quitamos action -->
<form id="formReserva" class="bg-white p-6 rounded shadow max-w-md">

<label>Fecha</label>
<input type="date" name="fecha" required class="w-full mb-3 p-2 border rounded" min="<?= date('Y-m-d') ?>">

<label>Hora inicio</label>
<input type="time" name="inicio" required class="w-full mb-3 p-2 border rounded">

<label>Hora fin</label>
<input type="time" name="fin" required class="w-full mb-3 p-2 border rounded">

<label>Mesa</label>
<select name="mesa" required class="w-full mb-4 p-2 border rounded">
<?php while ($m = $mesas->fetch_assoc()) { ?>
<option value="<?= $m['id_mesa'] ?>">
Mesa <?= htmlspecialchars($m['numero']) ?>
</option>
<?php } ?>
</select>

<button class="bg-green-500 text-white px-4 py-2 rounded w-full">
Crear reserva
</button>

</form>

<!-- MENSAJE DINÁMICO -->
<div id="mensajeAjax" class="mt-4"></div>

<!-- JS -->
<script src="../resources/js/reservas.js"></script>

<?php require_once "../includes/footer.php"; ?>