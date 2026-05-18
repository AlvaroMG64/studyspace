document.addEventListener("DOMContentLoaded", () => {

    const biblioteca = document.getElementById("biblioteca");
    const sala = document.getElementById("sala");
    const mesa = document.getElementById("mesa");

    // CARGAR SALAS
    if (biblioteca) {

        biblioteca.addEventListener("change", async () => {

            sala.innerHTML = `
                <option value="">
                    Cargando salas...
                </option>
            `;

            mesa.innerHTML = `
                <option value="">
                    Seleccionar mesa
                </option>
            `;

            let response = await fetch(
                `../api/salas.php?biblioteca=${biblioteca.value}`
            );

            let data = await response.json();

            sala.innerHTML = `
                <option value="">
                    Seleccionar sala
                </option>
            `;

            data.forEach(item => {

                sala.innerHTML += `
                    <option value="${item.id_sala}">
                        ${item.nombre_s}
                    </option>
                `;
            });
        });
    }

    // CARGAR MESAS
    if (sala) {

        sala.addEventListener("change", async () => {

            mesa.innerHTML = `
                <option value="">
                    Cargando mesas...
                </option>
            `;

            let response = await fetch(
                `../api/mesas.php?sala=${sala.value}`
            );

            let data = await response.json();

            mesa.innerHTML = `
                <option value="">
                    Seleccionar mesa
                </option>
            `;

            data.forEach(item => {

                mesa.innerHTML += `
                    <option value="${item.id_mesa}">
                        Mesa ${item.numero}
                    </option>
                `;
            });
        });
    }

    // FORMULARIO AJAX
    const form = document.getElementById("formReserva");

    if (!form) return;

    form.addEventListener("submit", async (e) => {

        e.preventDefault();

        let formData = new FormData(form);

        let biblioteca = document.getElementById("biblioteca").value;
        let sala = document.getElementById("sala").value;
        let mesa = document.getElementById("mesa").value;

        let fecha = formData.get("fecha");
        let inicio = formData.get("inicio");
        let fin = formData.get("fin");

        // VALIDAR CAMPOS

        if (!biblioteca) {
            mostrarMensaje(
                "Debes seleccionar una biblioteca",
                "error"
            );
            return;
        }

        if (!sala) {
            mostrarMensaje(
                "Debes seleccionar una sala",
                "error"
            );
            return;
        }

        if (!mesa) {
            mostrarMensaje(
                "Debes seleccionar una mesa",
                "error"
            );
            return;
        }

        if (!fecha) {
            mostrarMensaje(
                "Debes seleccionar una fecha",
                "error"
            );
            return;
        }

        if (!inicio) {
            mostrarMensaje(
                "Debes seleccionar una hora de inicio",
                "error"
            );
            return;
        }

        if (!fin) {
            mostrarMensaje(
                "Debes seleccionar una hora de fin",
                "error"
            );
            return;
        }

        // VALIDAR FECHA

        let hoy = new Date().toISOString().split("T")[0];

        if (fecha < hoy) {

            mostrarMensaje(
                "No puedes realizar reservas en fechas anteriores al día actual",
                "error"
            );

            return;
        }

        // VALIDAR HORAS

        if (inicio >= fin) {

            mostrarMensaje(
                "La hora de fin debe ser posterior a la hora de inicio",
                "error"
            );

            return;
        }

        try {

            let response = await fetch(
                "../api/reservas.php",
                {
                    method: "POST",
                    body: formData
                }
            );

            let data = await response.json();

            if (data.success) {

                window.location.href =
                    "../reservas/mis_reservas.php";

            } else {

                mostrarMensaje(data.message, "error");
            }

        } catch (error) {

            mostrarMensaje(
                "Error de conexión con el servidor",
                "error"
            );
        }
    });

});

// MENSAJES
function mostrarMensaje(texto, tipo) {

    const div = document.getElementById("mensajeAjax");

    div.innerHTML = `
        <div class="
            p-4
            rounded-xl
            shadow
            ${
                tipo === "success"
                ? "bg-green-100 text-green-700 border border-green-400"
                : "bg-red-100 text-red-700 border border-red-400"
            }
        ">
            ${texto}
        </div>
    `;
}