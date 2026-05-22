document.addEventListener(
    "DOMContentLoaded",
    () => {

        const biblioteca =
            document.getElementById(
                "biblioteca"
            );

        const sala =
            document.getElementById(
                "sala"
            );

        const mesa =
            document.getElementById(
                "mesa"
            );

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

                    try {

                        const response =
                            await fetch(
                                `/studyspace/public/api/salas?biblioteca=${biblioteca.value}`
                            );

                        if (!response.ok) {
                            throw new Error();
                        }

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

                    } catch {

                        mostrarMensaje(
                            "Error cargando salas",
                            "error"
                        );
                    }
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

                    try {

                        const response =
                            await fetch(
                                `/studyspace/public/api/mesas?sala=${sala.value}`
                            );

                        if (!response.ok) {
                            throw new Error();
                        }

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

                    } catch {

                        mostrarMensaje(
                            "Error cargando mesas",
                            "error"
                        );
                    }
                }
            );
        }

        // FORMULARIO

        const form =
            document.getElementById(
                "formReserva"
            );

        if (!form) {
            return;
        }

        form.addEventListener(
            "submit",
            async (e) => {

                e.preventDefault();

                const formData =
                    new FormData(form);

                const bibliotecaValue =
                    biblioteca.value;

                const salaValue =
                    sala.value;

                const mesaValue =
                    mesa.value;

                const fecha =
                    formData.get("fecha");

                const inicio =
                    formData.get("inicio");

                const fin =
                    formData.get("fin");

                // VALIDACIONES

                if (!bibliotecaValue) {

                    mostrarMensaje(
                        "Debes seleccionar una biblioteca",
                        "error"
                    );

                    return;
                }

                if (!salaValue) {

                    mostrarMensaje(
                        "Debes seleccionar una sala",
                        "error"
                    );

                    return;
                }

                if (!mesaValue) {

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

                const hoy =
                    new Date()
                    .toISOString()
                    .split("T")[0];

                if (fecha < hoy) {

                    mostrarMensaje(
                        "No puedes reservar en fechas pasadas",
                        "error"
                    );

                    return;
                }

                if (inicio >= fin) {

                    mostrarMensaje(
                        "La hora de fin debe ser posterior",
                        "error"
                    );

                    return;
                }

                try {

                    const response =
                        await fetch(
                            "/studyspace/public/guardar-reserva",
                            {
                                method: "POST",
                                body: formData
                            }
                        );

                    if (!response.ok) {
                        throw new Error();
                    }

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

                } catch {

                    mostrarMensaje(
                        "Error de conexión",
                        "error"
                    );
                }
            }
        );
    }
);

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