document.addEventListener("DOMContentLoaded", () => {

    let isSubmitting = false;

    const biblioteca = document.getElementById("biblioteca");
    const sala = document.getElementById("sala");
    const mesa = document.getElementById("mesa");

    function setLoading(btn, loading) {

        if (!btn) return;

        btn.disabled = loading;
    }

    function resetSelect(select, placeholder) {
        if (!select) return;
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    }

    // ======================
    // SALAS
    // ======================

    if (biblioteca && sala && mesa) {

        biblioteca.addEventListener("change", async () => {

            resetSelect(sala, "Seleccionar sala");
            resetSelect(mesa, "Seleccionar mesa");

            if (!biblioteca.value) return;

            sala.innerHTML = `<option>Cargando...</option>`;
            sala.disabled = true;

            try {
                const response = await fetch(
                    `/api/salas?biblioteca=${biblioteca.value}`
                );

                const data = await response.json();

                sala.innerHTML = `<option value="">Seleccionar sala</option>`;
                sala.disabled = false;

                data.forEach(item => {
                    sala.innerHTML += `
                        <option value="${item.id_sala}">
                            ${item.nombre_s}
                        </option>
                    `;
                });

            } catch (error) {
                console.error(error);
            }
        });
    }

    // ======================
    // MESAS
    // ======================

    if (sala && mesa) {

        sala.addEventListener("change", async () => {

            resetSelect(mesa, "Seleccionar mesa");

            if (!sala.value) return;

            mesa.innerHTML = `<option>Cargando...</option>`;
            mesa.disabled = true;

            try {
                const response = await fetch(
                    `/api/mesas?sala=${sala.value}`
                );

                const data = await response.json();

                mesa.innerHTML = `<option value="">Seleccionar mesa</option>`;
                mesa.disabled = false;

                data.forEach(item => {
                    mesa.innerHTML += `
                        <option value="${item.id_mesa}">
                            Mesa ${item.numero}
                        </option>
                    `;
                });

            } catch (error) {
                console.error(error);
            }
        });
    }

    // ======================
    // CREAR
    // ======================

    const formReserva = document.getElementById("formReserva");

    if (formReserva) {

        formReserva.addEventListener("submit", async (e) => {

            e.preventDefault();

            if (isSubmitting) return;

            isSubmitting = true;

            const btn = formReserva.querySelector("button[type='submit']");
            const formData = new FormData(formReserva);

            // solo bloquear botón
            setLoading(btn, true);

            try {

                const res = await fetch("/guardar-reserva", {
                    method: "POST",
                    body: formData
                });

                const data = await res.json();

                if (!data || typeof data.success === "undefined") {
                    showToast("error", "Respuesta inválida del servidor");
                    return;
                }

                if (data.success === true) {

                    showToast(
                        "success",
                        data.message || "Reserva creada correctamente"
                    );

                    document.dispatchEvent(new Event("reservas:updated"));

                    setTimeout(() => {
                        window.location.href =
                            "/mis-reservas";
                    }, 600);

                } else {

                    showToast(
                        "error",
                        data.message || "Error en la operación"
                    );
                }

            } catch (e) {

                showToast("error", "Error de conexión");

            } finally {

                // desbloquear botón
                setLoading(btn, false);

                isSubmitting = false;
            }
        });
    }

    // ======================
    // EDITAR
    // ======================

    const formEditar = document.getElementById("formEditar");

    if (formEditar) {

        formEditar.addEventListener("submit", async (e) => {

            e.preventDefault();

            if (isSubmitting) return;

            isSubmitting = true;

            const btn = formEditar.querySelector("button[type='submit']");
            const formData = new FormData(formEditar);

            // solo bloquear botón
            setLoading(btn, true);

            try {

                const res = await fetch("/actualizar-reserva", {
                    method: "POST",
                    body: formData
                });

                const data = await res.json();

                if (!data || typeof data.success === "undefined") {
                    showToast("error", "Respuesta inválida del servidor");
                    return;
                }

                if (data.success === true) {

                    showToast(
                        "success",
                        data.message || "Cambios guardados correctamente"
                    );

                    document.dispatchEvent(new Event("reservas:updated"));

                    setTimeout(() => {
                        window.location.href =
                            "/mis-reservas";
                    }, 600);

                } else {

                    showToast(
                        "error",
                        data.message || "Error en la operación"
                    );
                }

            } catch (e) {

                showToast("error", "Error de conexión");

            } finally {

                // desbloquear botón
                setLoading(btn, false);

                isSubmitting = false;
            }
        });

        precargarEdicion();
    }

    // ======================
    // ELIMINAR
    // ======================

    document.addEventListener("click", (e) => {

        const btn = e.target.closest(".btnEliminar");
        if (!btn) return;

        showConfirm(
            "¿Seguro que deseas eliminar esta reserva?",
            async () => {

                const id = btn.dataset.id;
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

                if (!csrf) {
                    showToast("error", "Error de seguridad: CSRF no disponible");
                    return;
                }

                try {

                    const formData = new FormData();
                    formData.append("id", id);
                    formData.append("csrf_token", csrf);

                    const res = await fetch("/eliminar-reserva", {
                        method: "POST",
                        body: formData
                    });

                    const data = await res.json();

                    if (!data.success) {
                        showToast("error", data.message || "Error al eliminar");
                        return;
                    }

                    document.getElementById(`fila-${id}`)?.remove();

                    showToast("success", "Reserva eliminada");

                    document.dispatchEvent(new Event("reservas:updated"));

                } catch (e) {
                    console.error(e);
                    showToast("error", "Error de conexión");
                }
            }
        );
    });

});

// ======================
// PRECARGA EDICIÓN 
// ======================

async function precargarEdicion() {

    const biblioteca = document.getElementById("biblioteca");
    const sala = document.getElementById("sala");
    const mesa = document.getElementById("mesa");

    if (!biblioteca?.value) return;

    const salas = await cargarSalas(biblioteca.value);

    if (sala.dataset.selected) {
        sala.value = sala.dataset.selected;
    }

    const mesas = await cargarMesas(sala.value);

    if (mesa.dataset.selected) {
        mesa.value = mesa.dataset.selected;
    }
}

function esperarOpciones(select) {
    return new Promise(resolve => {
        const interval = setInterval(() => {
            if (select.options.length > 1) {
                clearInterval(interval);
                resolve();
            }
        }, 50);
    });
}

async function cargarSalas(idBiblioteca) {

    const sala = document.getElementById("sala");
    const mesa = document.getElementById("mesa");

    if (!idBiblioteca) return [];

    // estado limpio
    sala.disabled = true;
    mesa.disabled = true;

    sala.innerHTML = `<option value="">Cargando...</option>`;

    try {

        const res = await fetch(`/api/salas?biblioteca=${idBiblioteca}`);
        const data = await res.json();

        sala.innerHTML = `<option value="">Seleccionar sala</option>`;
        sala.disabled = false;

        data.forEach(item => {
            sala.innerHTML += `
                <option value="${item.id_sala}">
                    ${item.nombre_s}
                </option>
            `;
        });

        return data;

    } catch (error) {

        console.error(error);
        sala.innerHTML = `<option value="">Error al cargar salas</option>`;
        return [];
    }
}

async function cargarMesas(idSala) {

    const mesa = document.getElementById("mesa");

    if (!idSala) return [];

    mesa.disabled = true;
    mesa.innerHTML = `<option value="">Cargando...</option>`;

    try {

        const res = await fetch(`/api/mesas?sala=${idSala}`);
        const data = await res.json();

        mesa.innerHTML = `<option value="">Seleccionar mesa</option>`;
        mesa.disabled = false;

        data.forEach(item => {
            mesa.innerHTML += `
                <option value="${item.id_mesa}">
                    Mesa ${item.numero}
                </option>
            `;
        });

        return data;

    } catch (error) {

        console.error(error);
        mesa.innerHTML = `<option value="">Error al cargar mesas</option>`;
        return [];
    }
}

async function refrescarReservas() {

    const contenedor = document.getElementById("contenedorReservas");
    if (!contenedor) return;

    contenedor.innerHTML = "<p>Cargando...</p>";

    try {

        const res = await fetch("/api/mis-reservas");
        const data = await res.json();

        if (!Array.isArray(data) || data.length === 0) {

            contenedor.innerHTML = `
                <div class="text-center p-4">
                    <h3>No tienes reservas</h3>
                    <p>Todavía no has realizado ninguna reserva</p>
                </div>
            `;
            return;
        }

        contenedor.innerHTML = "";

        data.forEach(r => {
            contenedor.innerHTML += `
                <div class="fila-reserva" id="fila-${r.id}">
                    <p>${r.nombre}</p>
                    <button class="btnEliminar" data-id="${r.id}">Eliminar</button>
                </div>
            `;
        });

    } catch (e) {

        console.error(e);

        contenedor.innerHTML = `
            <p class="text-red-500">Error al cargar reservas</p>
        `;
    }
}