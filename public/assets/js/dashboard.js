document.addEventListener("DOMContentLoaded", () => {

    inicializarDashboard();
    inicializarEliminar();
    inicializarFiltros();
    cargarTree();

});

// =========================
// DASHBOARD
// =========================

function inicializarDashboard() {

    const filas = document.querySelectorAll(".filaReserva");

    const totalReservas = document.getElementById("totalReservas");
    const totalUsuarios = document.getElementById("totalUsuarios");
    const totalMesas = document.getElementById("totalMesas");
    const reservasHoy = document.getElementById("reservasHoy");

    if (!totalReservas || !totalUsuarios || !totalMesas || !reservasHoy) {
        return;
    }

    totalReservas.innerText = filas.length;

    totalUsuarios.innerText =
        new Set([...filas].map(f => f.dataset.usuario)).size;

    totalMesas.innerText =
        new Set([...filas].map(f => f.dataset.mesa)).size;

    const hoy = new Date().toISOString().split("T")[0];

    reservasHoy.innerText =
        [...filas].filter(f => f.dataset.fecha === hoy).length;

    generarGrafica();
}

// =========================
// FILTROS
// =========================

function inicializarFiltros() {

    const u =
        document.getElementById("filtroUsuario");

    const f =
        document.getElementById("filtroFecha");

    const b =
        document.getElementById("filtroBiblioteca");

    const reset =
        document.getElementById("btnLimpiarFiltros");

    if (!u || !f || !b || !reset) {
        return;
    }

    const aplicar = () => {

        document.querySelectorAll(".filaReserva").forEach(row => {

            const ok =
                row.dataset.usuario
                    .toLowerCase()
                    .includes(u.value.toLowerCase())

                &&

                (!f.value || row.dataset.fecha === f.value)

                &&

                row.dataset.biblioteca
                    .toLowerCase()
                    .includes(b.value.toLowerCase());

            row.style.display =
                ok ? "" : "none";
        });
    };

    u.oninput = aplicar;
    f.onchange = aplicar;
    b.oninput = aplicar;

    reset.onclick = () => {

        u.value = "";
        f.value = "";
        b.value = "";

        aplicar();
    };
}

// =========================
// TREE
// =========================

async function cargarTree() {

    const container =
        document.getElementById("studyspaceTree");

    if (!container) {
        return;
    }

    try {

        const res = await fetch(
            "/api/bibliotecas-tree"
        );

        const data = await res.json();

        if (!Array.isArray(data)) {

            container.innerHTML = `
                <p class="text-red-600">
                    Error cargando estructura
                </p>
            `;

            return;
        }

        container.innerHTML = "";

        data.forEach(biblioteca => {

            const card =
                document.createElement("div");

            card.className = `
                border
                rounded-3xl
                p-6
                bg-gray-50
            `;

            let html = `
                <h3 class="
                    text-2xl
                    font-bold
                    mb-4
                    text-blue-700
                ">
                    ${biblioteca.nombre}
                </h3>
            `;

            biblioteca.salas.forEach(sala => {

                html += `
                    <div class="mb-4">

                        <h4 class="
                            font-semibold
                            text-lg
                            mb-2
                        ">
                            ${sala.nombre}
                        </h4>

                        <div class="
                            flex
                            flex-wrap
                            gap-2
                        ">
                `;

                sala.mesas.forEach(mesa => {

                    html += `
                        <span class="
                            bg-white
                            border
                            px-3
                            py-1
                            rounded-xl
                            text-sm
                        ">
                            Mesa ${mesa.numero}
                        </span>
                    `;
                });

                html += `
                        </div>
                    </div>
                `;
            });

            card.innerHTML = html;

            container.appendChild(card);
        });

    } catch (e) {

        console.error(e);

        container.innerHTML = `
            <p class="text-red-600">
                Error cargando estructura
            </p>
        `;
    }
}

// =========================
// GRÁFICA
// =========================

let chartInstance = null;

function generarGrafica() {

    const filas =
        document.querySelectorAll(".filaReserva");

    const map = {};

    filas.forEach(f => {
        map[f.dataset.fecha] =
            (map[f.dataset.fecha] || 0) + 1;
    });

    const ctx =
        document.getElementById("graficaReservas");

    if (!ctx) return;

    // FIX: destruir anterior gráfico
    if (chartInstance) {
        chartInstance.destroy();
    }

    chartInstance = new Chart(ctx, {
        type: "bar",

        data: {
            labels: Object.keys(map),

            datasets: [{
                label: "Reservas",
                data: Object.values(map),
                borderWidth: 2
            }]
        }
    });
}

async function refrescarDashboard() {

    try {

        const res = await fetch("/api/stats");
        const data = await res.json();

        document.getElementById("totalReservas").innerText =
            data.totalReservas ?? 0;

        document.getElementById("totalUsuarios").innerText =
            data.totalUsuarios ?? 0;

        document.getElementById("totalMesas").innerText =
            data.totalMesas ?? 0;

        document.getElementById("reservasHoy").innerText =
            data.reservasHoy ?? 0;

    } catch (e) {

        console.error("Error refrescando dashboard", e);
    }
}

function recalcularDashboard() {

    const filas = document.querySelectorAll(".filaReserva");

    const totalReservas = document.getElementById("totalReservas");
    const totalUsuarios = document.getElementById("totalUsuarios");
    const totalMesas = document.getElementById("totalMesas");
    const reservasHoy = document.getElementById("reservasHoy");

    if (!totalReservas) return;

    totalReservas.innerText = filas.length;

    totalUsuarios.innerText =
        new Set([...filas].map(f => f.dataset.usuario)).size;

    totalMesas.innerText =
        new Set([...filas].map(f => f.dataset.mesa)).size;

    const hoy = new Date().toISOString().split("T")[0];

    reservasHoy.innerText =
        [...filas].filter(f => f.dataset.fecha === hoy).length;

    generarGrafica();
}

document.addEventListener("reservas:updated", () => {
    refrescarDashboard();
    recalcularDashboard();
});