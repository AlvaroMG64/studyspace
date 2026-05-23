async function cargarDashboard() {

    try {

        const response = await fetch(
            "/studyspace/public/api/stats"
        );

        const data = await response.json();

        document.getElementById(
            "totalReservas"
        ).innerText = data.totalReservas;

        document.getElementById(
            "totalUsuarios"
        ).innerText = data.totalUsuarios;

        document.getElementById(
            "totalMesas"
        ).innerText = data.totalMesas;

        document.getElementById(
            "reservasHoy"
        ).innerText = data.reservasHoy;

        const labels = data.grafica.map(
            item => item.fecha_r
        );

        const valores = data.grafica.map(
            item => item.total
        );

        const ctx = document.getElementById(
            "graficaReservas"
        );

        new Chart(ctx, {

            type: "bar",

            data: {

                labels: labels,

                datasets: [{
                    label: "Reservas",
                    data: valores
                }]
            }
        });

    } catch (error) {

        console.error(error);
    }
}

cargarDashboard();