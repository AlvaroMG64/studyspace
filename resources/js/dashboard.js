async function cargarDashboard() {

    try {

        const response = await fetch(
            "/studyspace/public/api/stats"
        );

        if (!response.ok) {
            throw new Error(
                "Error cargando estadísticas"
            );
        }

        const data = await response.json();

        const totalReservas =
            document.getElementById(
                "totalReservas"
            );

        const totalUsuarios =
            document.getElementById(
                "totalUsuarios"
            );

        const totalMesas =
            document.getElementById(
                "totalMesas"
            );

        const reservasHoy =
            document.getElementById(
                "reservasHoy"
            );

        if (
            totalReservas &&
            totalUsuarios &&
            totalMesas &&
            reservasHoy
        ) {

            totalReservas.innerText =
                data.totalReservas;

            totalUsuarios.innerText =
                data.totalUsuarios;

            totalMesas.innerText =
                data.totalMesas;

            reservasHoy.innerText =
                data.reservasHoy;
        }

        const ctx =
            document.getElementById(
                "graficaReservas"
            );

        if (!ctx) {
            return;
        }

        const labels =
            data.grafica.map(
                item => item.fecha_r
            );

        const valores =
            data.grafica.map(
                item => item.total
            );

        new Chart(ctx, {

            type: "bar",

            data: {

                labels: labels,

                datasets: [
                    {
                        label: "Reservas",
                        data: valores
                    }
                ]
            }
        });

    } catch (error) {

        console.error(error);
    }
}

document.addEventListener(
    "DOMContentLoaded",
    cargarDashboard
);