async function cargarDashboard() {

    try {

        let response = await fetch("../api/stats.php");
        let data = await response.json();

        // CARDS
        document.getElementById("totalReservas").innerText = data.totalReservas;
        document.getElementById("totalUsuarios").innerText = data.totalUsuarios;
        document.getElementById("totalMesas").innerText = data.totalMesas;
        document.getElementById("reservasHoy").innerText = data.reservasHoy;

        // GRÁFICA
        let labels = data.grafica.map(item => item.fecha_r);
        let valores = data.grafica.map(item => item.total);

        let ctx = document.getElementById("graficaReservas");

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