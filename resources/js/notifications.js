function showToast(type, message) {
    const colors = {
        success: "bg-green-600",
        error: "bg-red-600",
        warning: "bg-yellow-500",
        info: "bg-blue-600"
    };

    const icons = {
        success: "✔️",
        error: "❌",
        warning: "⚠️",
        info: "ℹ️"
    };

    const toast = document.createElement("div");

    toast.className = `
        fixed top-6 right-6 z-[9999]
        px-6 py-4 rounded-2xl shadow-xl
        text-white font-semibold
        flex items-center gap-3
        animate-fade-in
        ${colors[type] || colors.info}
    `;

    toast.innerHTML = `
        <span>${icons[type] || ""}</span>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

/* =========================
   MODAL DE CONFIRMACIÓN
========================= */

function showConfirm(message, onConfirm) {
    const modal = document.createElement("div");

    modal.className = `
        fixed inset-0 bg-black/50
        flex items-center justify-center
        z-[9999]
    `;

    modal.innerHTML = `
        <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md text-center">

            <h2 class="text-2xl font-bold mb-4 font-display">
                Confirmación
            </h2>

            <p class="text-gray-600 mb-6">
                ${message}
            </p>

            <div class="flex gap-4">

                <button id="cancelBtn"
                    class="flex-1 bg-gray-200 py-3 rounded-xl">
                    Cancelar
                </button>

                <button id="confirmBtn"
                    class="flex-1 bg-red-600 text-white py-3 rounded-xl">
                    Confirmar
                </button>

            </div>

        </div>
    `;

    document.body.appendChild(modal);

    document.getElementById("cancelBtn").onclick = () => {
        modal.remove();
    };

    document.getElementById("confirmBtn").onclick = () => {
        modal.remove();
        onConfirm();
    };
}