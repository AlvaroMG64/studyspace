document.addEventListener("DOMContentLoaded", () => {

    const biblioteca =
        document.getElementById("biblioteca");

    const sala =
        document.getElementById("sala");

    const mesa =
        document.getElementById("mesa");

    // CARGAR SALAS
    if (biblioteca) {

        biblioteca.addEventListener(
            "change",
            async () => {

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

                const response = await fetch(
                    `/studyspace/public/api/salas?biblioteca=${biblioteca.value}`
                );

                const data =
                    await response.json();

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
            }
        );
    }

    // CARGAR MESAS
    if (sala) {

        sala.addEventListener(
            "change",
            async () => {

                mesa.innerHTML = `
                    <option value="">
                        Cargando mesas...
                    </option>
                `;

                const response = await fetch(
                    `/studyspace/public/api/mesas?sala=${sala.value}`
                );

                const data =
                    await response.json();

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
            }
        );
    }

    // FORM CREAR RESERVA
    const form =
        document.getElementById("formReserva");

    if (form) {

        form.addEventListener(
            "submit",
            async (e) => {

                e.preventDefault();

                const formData =
                    new FormData(form);

                try {

                    const response =
                        await fetch(
                            "/studyspace/public/guardar-reserva",
                            {
                                method: "POST",
                                body: formData
                            }
                        );

                    const data =
                        await response.json();

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
            }
        );
    }

    // ELIMINAR RESERVA
    const botonesEliminar =
        document.querySelectorAll(".btnEliminar");

    botonesEliminar.forEach(btn => {

        btn.addEventListener(
            "click",
            async (e) => {

                e.preventDefault();

                if (
                    !confirm(
                        "¿Eliminar reserva?"
                    )
                ) {
                    return;
                }

                const id =
                    btn.dataset.id;

                const formData =
                    new FormData();

                formData.append("id", id);

                try {

                    const response =
                        await fetch(
                            "/studyspace/public/api/eliminar-reserva",
                            {
                                method: "POST",
                                body: formData
                            }
                        );

                    const data =
                        await response.json();

                    if (data.success) {

                        document
                            .getElementById(
                                `fila-${id}`
                            )
                            .remove();

                    } else {

                        alert(data.message);
                    }

                } catch (error) {

                    alert(
                        "Error de conexión"
                    );
                }
            }
        );
    });

});

// MENSAJES
function mostrarMensaje(
    texto,
    tipo
) {

    const div =
        document.getElementById(
            "mensajeAjax"
        );

    if (!div) {
        return;
    }

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