document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("formReserva");

    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        let formData = new FormData(form);

        let inicio = formData.get("inicio");
        let fin = formData.get("fin");

        // Validación básica
        if (inicio >= fin) {
            mostrarMensaje("Hora incorrecta", "error");
            return;
        }

        try {
            let response = await fetch("../api/reservas.php", {
                method: "POST",
                body: formData
            });

            let data = await response.json();

            if (data.success) {
                mostrarMensaje(data.message, "success");
                form.reset();
            } else {
                mostrarMensaje(data.message, "error");
            }

        } catch (error) {
            mostrarMensaje("Error de conexión", "error");
        }
    });

});

// Mostrar mensajes dinámicos
function mostrarMensaje(texto, tipo) {

    const div = document.getElementById("mensajeAjax");

    div.innerHTML = `
        <div class="p-3 rounded ${
            tipo === "success" 
            ? "bg-green-100 text-green-700 border border-green-400" 
            : "bg-red-100 text-red-700 border border-red-400"
        }">
            ${texto}
        </div>
    `;
}

// ELIMINAR RESERVA AJAX
document.addEventListener("click", async (e) => {

    if (e.target.classList.contains("btnEliminar")) {

        e.preventDefault();

        let confirmar = confirm("¿Eliminar reserva?");

        if (!confirmar) return;

        let id = e.target.dataset.id;

        let formData = new FormData();
        formData.append("id", id);

        try {

            let response = await fetch("../api/eliminar_reserva.php", {
                method: "POST",
                body: formData
            });

            let data = await response.json();

            if (data.success) {

                // BORRAR FILA
                document.getElementById("fila-" + id).remove();

                alert(data.message);

            } else {

                alert(data.message);
            }

        } catch (error) {

            alert("Error de conexión");
        }
    }

});