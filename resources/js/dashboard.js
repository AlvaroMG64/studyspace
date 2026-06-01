document.addEventListener("DOMContentLoaded", () => {

    inicializarDashboard();

    inicializarEliminar();

    inicializarFiltros();

});

// =====================================
// DASHBOARD
// =====================================

function inicializarDashboard() {

    const totalReservas =
        document.querySelectorAll(".filaReserva").length;

    const totalUsuarios =
        new Set(
            Array.from(
                document.querySelectorAll(".filaReserva")
            ).map(
                fila => fila.dataset.usuario
            )
        ).size;

    const totalMesas =
        new Set(
            Array.from(
                document.querySelectorAll(".filaReserva")
            ).map(
                fila => fila.dataset.mesa
            )
        ).size;

    const hoy =
        new Date()
            .toISOString()
            .split("T")[0];

    const reservasHoy =
        Array.from(
            document.querySelectorAll(".filaReserva")
        ).filter(
            fila => fila.dataset.fecha === hoy
        ).length;

    // CARDS

    document.getElementById(
        "totalReservas"
    ).innerText = totalReservas;

    document.getElementById(
        "totalUsuarios"
    ).innerText = totalUsuarios;

    document.getElementById(
        "totalMesas"
    ).innerText = totalMesas;

    document.getElementById(
        "reservasHoy"
    ).innerText = reservasHoy;

    // GRAFICA

    generarGrafica();
}

// =====================================
// GRAFICA
// =====================================

function generarGrafica() {

    const filas =
        document.querySelectorAll(".filaReserva");

    const reservasPorFecha = {};

    filas.forEach(fila => {

        const fecha =
            fila.dataset.fecha;

        if (!reservasPorFecha[fecha]) {

            reservasPorFecha[fecha] = 0;
        }

        reservasPorFecha[fecha]++;
    });

    const labels =
        Object.keys(reservasPorFecha);

    const datos =
        Object.values(reservasPorFecha);

    const canvas =
        document.getElementById(
            "graficaReservas"
        );

    if (!canvas) return;

    new Chart(canvas, {

        type: "bar",

        data: {

            labels,

            datasets: [
                {
                    label: "Reservas",
                    data: datos,
                    borderWidth: 2
                }
            ]
        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    display: false
                }
            }
        }
    });
}

// =====================================
// FILTROS
// =====================================

function inicializarFiltros() {

    const filtroUsuario =
        document.getElementById(
            "filtroUsuario"
        );

    const filtroFecha =
        document.getElementById(
            "filtroFecha"
        );

    function aplicarFiltros() {

        const filas =
            document.querySelectorAll(".filaReserva");

        filas.forEach(fila => {

            const usuario =
                fila.dataset.usuario.toLowerCase();

            const fecha =
                fila.dataset.fecha;

            const coincideUsuario =
                usuario.includes(
                    filtroUsuario.value.toLowerCase()
                );

            const coincideFecha =
                !filtroFecha.value
                || fecha === filtroFecha.value;

            fila.style.display =
                coincideUsuario && coincideFecha
                    ? ""
                    : "none";
        });
    }

    filtroUsuario?.addEventListener(
        "input",
        aplicarFiltros
    );

    filtroFecha?.addEventListener(
        "change",
        aplicarFiltros
    );
}

// =====================================
// ELIMINAR
// =====================================

function inicializarEliminar() {

    const botones =
        document.querySelectorAll(".btnEliminar");

    botones.forEach(btn => {

        btn.addEventListener(
            "click",
            () => {

                abrirModalEliminar(
                    btn.dataset.id
                );
            }
        );
    });
}

function abrirModalEliminar(id) {

    const overlay =
        document.createElement("div");

    overlay.className = `
        fixed inset-0
        bg-black/40
        flex items-center justify-center
        z-50
    `;

    overlay.innerHTML = `
        <div class="
            bg-white
            rounded-3xl
            shadow-2xl
            p-8
            w-full
            max-w-md
            text-center
        ">

            <h2 class="
                text-2xl
                font-bold
                mb-4
            ">
                Eliminar reserva
            </h2>

            <p class="text-gray-600 mb-8">
                ¿Seguro que deseas eliminar esta reserva?
            </p>

            <div class="flex gap-4">

                <button
                    class="
                        cancelarEliminar
                        flex-1
                        py-3
                        rounded-xl
                        bg-gray-200
                    "
                >
                    Cancelar
                </button>

                <button
                    class="
                        confirmarEliminar
                        flex-1
                        py-3
                        rounded-xl
                        bg-red-600
                        text-white
                    "
                >
                    Eliminar
                </button>

            </div>

        </div>
    `;

    document.body.appendChild(overlay);

    overlay
        .querySelector(".cancelarEliminar")
        .addEventListener(
            "click",
            () => {

                overlay.remove();
            }
        );

    overlay
        .querySelector(".confirmarEliminar")
        .addEventListener(
            "click",
            async () => {

                const formData =
                    new FormData();

                formData.append("id", id);

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

                    const fila =
                        document.getElementById(
                            `fila-${id}`
                        );

                    if (fila) {

                        fila.remove();
                    }

                    mostrarToast(
                        "Reserva eliminada"
                    );
                }

                overlay.remove();
            }
        );
}

// =====================================
// TOAST
// =====================================

function mostrarToast(texto) {

    const fondo =
        document.createElement("div");

    fondo.className = `
        fixed inset-0
        bg-white/60
        backdrop-blur-sm
        z-[9998]
    `;

    const toast =
        document.createElement("div");

    toast.className = `
        fixed
        top-1/2
        left-1/2
        -translate-x-1/2
        -translate-y-1/2
        bg-green-600
        text-white
        px-8
        py-4
        rounded-2xl
        shadow-2xl
        z-[9999]
        text-lg
        font-semibold
    `;

    toast.innerText = texto;

    document.body.appendChild(fondo);
    document.body.appendChild(toast);

    setTimeout(() => {

        fondo.remove();
        toast.remove();

    }, 1800);
}