</main>

<!-- UI SYSTEM GLOBAL -->
<script src="/studyspace/resources/js/ui-system.js"></script>

<!-- DASHBOARD -->
<script src="/studyspace/resources/js/dashboard.js"></script>

<!-- RESERVAS -->
<script src="/studyspace/resources/js/reservas.js"></script>

<script>

function confirmarLogout(event) {

    event.preventDefault();

    showConfirm("¿Seguro que desea cerrar sesión?", () => {

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
            window.location.href = "/studyspace/public/logout";
        }, 1200);
    });

    return false;
}

</script>

</body>
</html>