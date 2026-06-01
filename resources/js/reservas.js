document.addEventListener("DOMContentLoaded", () => {

    const biblioteca =
        document.getElementById("biblioteca");

    const sala =
        document.getElementById("sala");

    const mesa =
        document.getElementById("mesa");

    // ======================
    // CARGAR SALAS
    // ======================

    if (biblioteca) {

        biblioteca.addEventListener(
            "change",
            async () => {

                // RESET SALAS
                sala.innerHTML =
                    `<option value="">Seleccionar sala</option>`;

                // RESET MESAS
                mesa.innerHTML =
                    `<option value="">Seleccionar mesa</option>`;

                if (!biblioteca.value) {
                    return;
                }

                sala.innerHTML =
                    `<option>Cargando...</option>`;

                try {

                    const response =
                        await fetch(
                            `/studyspace/public/api/salas?biblioteca=${biblioteca.value}`
                        );

                    const data =
                        await response.json();

                    sala.innerHTML =
                        `<option value="">Seleccionar sala</option>`;

                    data.forEach(item => {

                        sala.innerHTML += `
                            <option value="${item.id_sala}">
                                ${item.nombre_s}
                            </option>
                        `;
                    });

                } catch (error) {

                    mostrarMensaje(
                        "Error cargando salas",
                        "error"
                    );
                }
            }
        );
    }

    // ======================
    // CARGAR MESAS
    // ======================

    if (sala) {

        sala.addEventListener(
            "change",
            async () => {

                mesa.innerHTML =
                    `<option value="">Seleccionar mesa</option>`;

                if (!sala.value) {
                    return;
                }

                mesa.innerHTML =
                    `<option>Cargando...</option>`;

                try {

                    const response =
                        await fetch(
                            `/studyspace/public/api/mesas?sala=${sala.value}`
                        );

                    const data =
                        await response.json();

                    mesa.innerHTML =
                        `<option value="">Seleccionar mesa</option>`;

                    data.forEach(item => {

                        mesa.innerHTML += `
                            <option value="${item.id_mesa}">
                                Mesa ${item.numero}
                            </option>
                        `;
                    });

                } catch (error) {

                    mostrarMensaje(
                        "Error cargando mesas",
                        "error"
                    );
                }
            }
        );
    }

    // ======================
    // CREAR
    // ======================

    const formReserva =
        document.getElementById("formReserva");

    if (formReserva) {

        formReserva.addEventListener(
            "submit",
            async (e) => {

                e.preventDefault();

                const formData =
                    new FormData(formReserva);

                if (!validarFormulario(formData)) {
                    return;
                }

                enviarFormulario(
                    "/studyspace/public/guardar-reserva",
                    formData,
                    "Reserva creada correctamente"
                );
            }
        );
    }

    // ======================
    // EDITAR
    // ======================

    const formEditar =
        document.getElementById("formEditar");

    if (formEditar) {

        formEditar.addEventListener(
            "submit",
            async (e) => {

                e.preventDefault();

                const formData =
                    new FormData(formEditar);

                if (!validarFormulario(formData)) {
                    return;
                }

                enviarFormulario(
                    "/studyspace/public/actualizar-reserva",
                    formData,
                    "Reserva actualizada correctamente"
                );
            }
        );
    }

    // ======================
    // ELIMINAR
    // ======================

    const botonesEliminar =
        document.querySelectorAll(".btnEliminar");

    botonesEliminar.forEach(btn => {

        btn.addEventListener(
            "click",
            () => {

                abrirModalEliminar(
                    btn.dataset.id
                );
            }
        );
    });

});

// ======================
// ENVIAR FORMULARIO
// ======================

async function enviarFormulario(
    url,
    formData,
    mensaje
) {

    try {

        const response =
            await fetch(url, {
                method: "POST",
                body: formData
            });

        const data =
            await response.json();

        if (data.success) {

            mostrarToastCentro(mensaje);

            setTimeout(() => {

                window.location.href =
                    "/studyspace/public/mis-reservas";

            }, 1200);

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

// ======================
// VALIDACIONES
// ======================

function validarFormulario(formData) {

    const fecha =
        formData.get("fecha");

    const inicio =
        formData.get("inicio");

    const fin =
        formData.get("fin");

    const hoy =
        new Date()
            .toISOString()
            .split("T")[0];

    if (!fecha) {

        mostrarMensaje(
            "Debe seleccionar una fecha",
            "error"
        );

        return false;
    }

    if (fecha < hoy) {

        mostrarMensaje(
            "No puede seleccionar fechas pasadas",
            "error"
        );

        return false;
    }

    if (!inicio || !fin) {

        mostrarMensaje(
            "Debe seleccionar un horario",
            "error"
        );

        return false;
    }

    if (inicio >= fin) {

        mostrarMensaje(
            "La hora de fin debe ser posterior a la de inicio",
            "error"
        );

        return false;
    }

    const mesa =
        formData.get("mesa");

    if (!mesa) {

        mostrarMensaje(
            "Debes seleccionar una mesa",
            "error"
        );

        return false;
    }

    return true;
}

// ======================
// MENSAJES EN CARD
// ======================

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
            rounded-2xl
            text-center
            font-medium
            shadow-sm
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

// ======================
// MODAL ELIMINAR
// ======================

function abrirModalEliminar(id) {

    const modal = document.createElement("div");

    modal.className = `
        fixed
        inset-0
        bg-black/50
        flex
        items-center
        justify-center
        z-50
    `;

    modal.innerHTML = `
        <div class="
            bg-white
            p-8
            rounded-3xl
            shadow-2xl
            w-full
            max-w-md
            text-center
        ">

            <h3 class="
                text-2xl
                font-bold
                mb-4
                font-display
            ">
                Eliminar reserva
            </h3>

            <p class="text-gray-600 mb-8">
                ¿Seguro que desea eliminar esta reserva?
            </p>

            <div class="flex gap-4">

                <button
                    id="cancelarEliminar"
                    class="
                    flex-1
                    bg-gray-200
                    py-3
                    rounded-xl
                    "
                >
                    Cancelar
                </button>

                <button
                    id="confirmarEliminar"
                    class="
                    flex-1
                    bg-red-600
                    text-white
                    py-3
                    rounded-xl
                    "
                >
                    Eliminar
                </button>

            </div>

        </div>
    `;

    document.body.appendChild(modal);

    document
        .getElementById("cancelarEliminar")
        .onclick = () => {

            modal.remove();
        };

    document
        .getElementById("confirmarEliminar")
        .onclick = async () => {

            const formData =
                new FormData();

            formData.append("id", id);

            try {

                const response =
                    await fetch(
                        "/studyspace/public/eliminar-reserva",
                        {
                            method: "POST",
                            body: formData
                        }
                    );

                const data =
                    await response.json();

                if (data.success) {

                    document
                        .getElementById(`fila-${id}`)
                        ?.remove();

                    mostrarToastCentro(
                        "Reserva eliminada"
                    );

                } else {

                    mostrarMensaje(
                        data.message,
                        "error"
                    );
                }

            } catch (error) {

                mostrarMensaje(
                    "Error eliminando reserva",
                    "error"
                );
            }

            modal.remove();
        };
}

// ======================
// TOAST CENTRADO
// ======================

function mostrarToastCentro(texto) {

    const overlay =
        document.createElement("div");

    overlay.className = `
        fixed
        inset-0
        bg-black/40
        flex
        items-center
        justify-center
        z-[9999]
    `;

    const toast =
        document.createElement("div");

    toast.className = `
        bg-white
        text-gray-800
        px-10
        py-6
        rounded-3xl
        shadow-2xl
        text-center
        max-w-md
        w-full
    `;

    toast.innerHTML = `
        <h3 class="
            text-2xl
            font-bold
            mb-2
            font-display
        ">
            ${texto}
        </h3>

        <p class="text-gray-500">
            Operación realizada correctamente
        </p>
    `;

    overlay.appendChild(toast);

    document.body.appendChild(overlay);

    setTimeout(() => {

        overlay.remove();

    }, 1800);
}