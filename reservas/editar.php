<?php
require_once "../includes/auth.php";
require_once "../config/db.php";
require_once "../includes/header.php";

if (!isset($_GET['id'])) {
    header("Location: mis_reservas.php");
    exit;
}

$id = intval($_GET['id']);
$usuario = $_SESSION['id'];

$stmt = $conn->prepare("SELECT * FROM reservas WHERE id_reserva = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$reserva = $stmt->get_result()->fetch_assoc();

if (!$reserva) {
    die("Reserva no encontrada");
}

if ($reserva['id_usuario'] != $usuario && !esAdmin()) {
    die("No autorizado");
}
?>

<h2 class="text-2xl font-bold mb-4">Editar Reserva</h2>

<form action="actualizar.php" method="POST" class="bg-white p-6 rounded shadow max-w-md">

<input type="hidden" name="id" value="<?= $id ?>">

<input type="date" name="fecha" value="<?= $reserva['fecha_r'] ?>" required class="w-full mb-3 p-2 border rounded">

<input type="time" name="inicio" value="<?= $reserva['hora_inicio'] ?>" required class="w-full mb-3 p-2 border rounded">

<input type="time" name="fin" value="<?= $reserva['hora_fin'] ?>" required class="w-full mb-3 p-2 border rounded">

<button class="bg-blue-500 text-white px-4 py-2 rounded w-full hover:bg-blue-600">
Actualizar
</button>

</form>

<script>
document.querySelector("form").addEventListener("submit", function(e) {
    let inicio = document.querySelector("[name=inicio]").value;
    let fin = document.querySelector("[name=fin]").value;

    if (inicio >= fin) {
        alert("Hora incorrecta");
        e.preventDefault();
    }
});
</script>

<?php require_once "../includes/footer.php"; ?>