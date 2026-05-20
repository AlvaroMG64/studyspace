<?php
require_once "../includes/auth.php";
require_once "../config/database.php";
require_once "../includes/header.php";

$conn = Database::connect();

if (!isset($_GET['id'])) {
    header("Location: mis_reservas.php");
    exit;
}

$id = intval($_GET['id']);
$usuario = $_SESSION['id'];

$stmt = $conn->prepare("
SELECT r.*, 
       m.id_mesa,
       m.numero,
       s.id_sala,
       b.id_biblioteca
FROM reservas r
JOIN mesas m ON r.id_mesa = m.id_mesa
JOIN salas s ON m.id_sala = s.id_sala
JOIN bibliotecas b ON s.id_biblioteca = b.id_biblioteca
WHERE r.id_reserva = ?
");

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

<h2 class="text-3xl font-bold mb-6">
Editar Reserva
</h2>

<form id="formEditar"
      class="bg-white p-6 rounded-2xl shadow-lg max-w-lg"
      novalidate>

<input type="hidden"
       name="id"
       value="<?= $id ?>">

<label class="font-semibold">
Fecha
</label>

<input type="date"
       name="fecha"
       value="<?= $reserva['fecha_r'] ?>"
       class="w-full p-3 border rounded-xl mb-4">

<label class="font-semibold">
Hora inicio
</label>

<input type="time"
       name="inicio"
       value="<?= $reserva['hora_inicio'] ?>"
       class="w-full p-3 border rounded-xl mb-4">

<label class="font-semibold">
Hora fin
</label>

<input type="time"
       name="fin"
       value="<?= $reserva['hora_fin'] ?>"
       class="w-full p-3 border rounded-xl mb-6">

<button
class="w-full py-3 rounded-xl text-white font-bold
bg-gradient-to-r from-blue-500 to-indigo-600
hover:scale-[1.02]
transition-all duration-200 shadow-lg">

Guardar cambios

</button>

</form>

<div id="mensajeAjax" class="mt-4"></div>

<script>

document.getElementById("formEditar")
.addEventListener("submit", async (e) => {

    e.preventDefault();

    let form = e.target;

    let formData = new FormData(form);

    let fecha = formData.get("fecha");
    let inicio = formData.get("inicio");
    let fin = formData.get("fin");

    if (!fecha) {

        mostrarMensaje(
            "Debes seleccionar una fecha",
            "error"
        );

        return;
    }

    if (!inicio) {

        mostrarMensaje(
            "Debes indicar la hora de inicio",
            "error"
        );

        return;
    }

    if (!fin) {

        mostrarMensaje(
            "Debes indicar la hora de fin",
            "error"
        );

        return;
    }

    if (inicio >= fin) {

        mostrarMensaje(
            "La hora de fin debe ser posterior a la hora de inicio",
            "error"
        );

        return;
    }

    try {

        let response = await fetch(
            "actualizar.php",
            {
                method: "POST",
                body: formData
            }
        );

        let data = await response.json();

        if (data.success) {

            window.location.href =
                "mis_reservas.php";

        } else {

            mostrarMensaje(
                data.message,
                "error"
            );
        }

    } catch (error) {

        mostrarMensaje(
            "Error de conexión",
            "error"
        );
    }

});

function mostrarMensaje(texto, tipo) {

    let div = document.getElementById("mensajeAjax");

    div.innerHTML = `
        <div class="
            p-4 rounded-xl border mt-4
            ${tipo === "success"
                ? "bg-green-100 text-green-700 border-green-400"
                : "bg-red-100 text-red-700 border-red-400"}
        ">
            ${texto}
        </div>
    `;
}

</script>

<?php require_once "../includes/footer.php"; ?>