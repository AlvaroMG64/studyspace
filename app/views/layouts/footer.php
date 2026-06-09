</main>

<!-- FOOTER -->
<footer class="mt-10 border-t border-gray-200 bg-white/60 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4">

        <!-- IZQUIERDA -->
        <div class="text-center md:text-left">
            <h3 class="font-bold text-gray-700 text-lg">
                StudySpace
            </h3>
            <p class="text-sm text-gray-500">
                Sistema de gestión de reservas de bibliotecas y salas de estudio
            </p>
        </div>

        <!-- CENTRO -->
        <div class="text-sm text-gray-500 text-center">
            © <?= date('Y') ?> StudySpace · Álvaro Mozo Gaspar
        </div>

        <!-- DERECHA -->
        <div class="flex gap-4 text-sm">
            <a href="<?= base_url('') ?>" class="text-gray-600 hover:text-blue-600 transition">
                Inicio
            </a>
        </div>

    </div>
</footer>

<script>

function confirmarLogout(event) {

    event.preventDefault();

    showConfirm("¿Seguro que deseas cerrar sesión?", () => {

        const modal = document.createElement("div");

        modal.className = `
            fixed inset-0
            bg-black/40
            backdrop-blur-sm
            flex items-center justify-center
            z-[9999]
        `;

        modal.innerHTML = `
            <div class="
                bg-white
                p-10
                rounded-3xl
                shadow-2xl
                text-center
                max-w-md
                w-full
            ">
                <h2 class="text-3xl font-bold mb-3">
                    Sesión cerrada
                </h2>

                <p class="text-gray-600">
                    Se ha cerrado la sesión con éxito
                </p>
            </div>
        `;

        document.body.appendChild(modal);

        setTimeout(() => {
            window.location.href = "<?= base_url('logout') ?>";
        }, 1200);
    });

    return false;
}

function actualizarFechaHora() {

    const reloj = document.getElementById('reloj');

    if (!reloj) return;

    const ahora = new Date();

    const fecha = ahora.toLocaleDateString('es-ES', {
        timeZone: 'Europe/Madrid'
    });

    const hora = ahora.toLocaleTimeString('es-ES', {
        timeZone: 'Europe/Madrid'
    });

    reloj.textContent = `${fecha} · ${hora}`;
}

actualizarFechaHora();

setInterval(actualizarFechaHora, 1000);

</script>

</body>
</html>