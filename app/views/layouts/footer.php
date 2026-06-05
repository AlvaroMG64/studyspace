</main>

<script>

    function confirmarLogout(event) {

        event.preventDefault();

        const modal =
            document.createElement("div");

        modal.className = `
            fixed inset-0
            bg-black/40
            flex items-center justify-center
            z-50
        `;

        modal.innerHTML = `
            <div class="
                bg-white
                p-8
                rounded-3xl
                shadow-2xl
                text-center
                max-w-md
                w-full
            ">

                <h2 class="
                    text-2xl
                    font-bold
                    mb-4
                    font-display
                ">
                    Cerrar sesión
                </h2>

                <p class="mb-8 text-gray-600">
                    ¿Seguro que deseas cerrar sesión?
                </p>

                <div class="flex gap-4">

                    <button
                        id="cancelLogout"
                        class="
                            flex-1
                            py-3
                            rounded-xl
                            bg-gray-200
                        "
                    >
                        Cancelar
                    </button>

                    <button
                        id="confirmLogout"
                        class="
                            flex-1
                            py-3
                            rounded-xl
                            bg-red-600
                            text-white
                        "
                    >
                        Salir
                    </button>

                </div>

            </div>
        `;

        document.body.appendChild(modal);

        document
            .getElementById("cancelLogout")
            .onclick = () => modal.remove();

        document
            .getElementById("confirmLogout")
            .onclick = () => {

                window.location.href =
                    "/studyspace/public/logout";
            };

        return false;
    }

</script>

<script src="/studyspace/resources/js/notifications.js"></script>

</body>
</html>