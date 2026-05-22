// app/views/reservas/editar.php

<?php require_once "../app/views/layouts/header.php"; ?>

<h2 class="text-3xl font-bold mb-6">
Editar Reserva
</h2>

<form
id="formEditar"
class="bg-white p-6 rounded-2xl shadow-lg max-w-lg"
novalidate
>

<input
type="hidden"
name="id"
value="<?= $reserva['id_reserva'] ?>"
>

<input
type="hidden"
name="mesa"
value="<?= $reserva['id_mesa'] ?>"
>

<label class="font-semibold">
Fecha
</label>

<input
type="date"
name="fecha"
value="<?= $reserva['fecha_r'] ?>"
class="w-full p-3 border rounded-xl mb-4"
>

<label class="font-semibold">
Hora inicio
</label>

<input
type="time"
name="inicio"
value="<?= $reserva['hora_inicio'] ?>"
class="w-full p-3 border rounded-xl mb-4"
>

<label class="font-semibold">
Hora fin
</label>

<input
type="time"
name="fin"
value="<?= $reserva['hora_fin'] ?>"
class="w-full p-3 border rounded-xl mb-6"
>

<button
class="
w-full
py-3
rounded-xl
text-white
font-bold
bg-gradient-to-r
from-blue-500
to-indigo-600
hover:scale-[1.02]
transition-all
duration-200
shadow-lg
"
>

Guardar cambios

</button>

</form>

<div id="mensajeAjax" class="mt-4"></div>

<script>

document.getElementById("formEditar")
.addEventListener("submit", async (e) => {

    e.preventDefault();

    let formData = new FormData(e.target);

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
            "/studyspace/public/actualizar-reserva",
            {
                method: "POST",
                body: formData
            }
        );

        let data = await response.json();

        if (data.success) {

            window.location.href =
                "/studyspace/public/mis-reservas";

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
            ${
                tipo === "success"
                ? "bg-green-100 text-green-700 border-green-400"
                : "bg-red-100 text-red-700 border-red-400"
            }
        ">
            ${texto}
        </div>
    `;
}

</script>

<?php require_once "../app/views/layouts/footer.php"; ?>