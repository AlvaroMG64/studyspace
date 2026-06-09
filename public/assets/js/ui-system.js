// =========================
// TOAST
// =========================

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

    const overlay =
        document.createElement("div");

    overlay.className = `
        fixed inset-0
        bg-black/40
        backdrop-blur-sm
        flex items-center justify-center
        z-[9998]
    `;

    const toast =
        document.createElement("div");

    toast.className = `
        ${colors[type] || colors.info}
        text-white
        px-8 py-5
        rounded-3xl
        shadow-2xl
        text-lg
        font-semibold
        flex items-center gap-4
        z-[9999]
    `;

    toast.innerHTML = `
        <span class="text-2xl">
            ${icons[type] || ""}
        </span>

        <span>
            ${message}
        </span>
    `;

    overlay.appendChild(toast);

    document.body.appendChild(overlay);

    setTimeout(() => {
        overlay.remove();
    }, 2200);
}

// =========================
// CONFIRM MODAL
// =========================

function showConfirm(message, onConfirm) {

    const modal =
        document.createElement("div");

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
            p-8
            rounded-3xl
            shadow-2xl
            w-full
            max-w-md
            text-center
        ">

            <h2 class="
                text-2xl
                font-bold
                mb-4
                font-display
            ">
                Confirmación
            </h2>

            <p class="text-gray-600 mb-8">
                ${message}
            </p>

            <div class="flex gap-4">

                <button
                    id="cancelBtn"
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
                    id="confirmBtn"
                    class="
                        flex-1
                        py-3
                        rounded-xl
                        bg-red-600
                        text-white
                    "
                >
                    Confirmar
                </button>

            </div>

        </div>
    `;

    document.body.appendChild(modal);

    modal.querySelector("#cancelBtn").onclick = () => {
        modal.remove();
    };

    modal.querySelector("#confirmBtn").onclick = () => {

        modal.remove();

        if (typeof onConfirm === "function") {
            onConfirm();
        }
    };
}

window.showToast = showToast;
window.showConfirm = showConfirm;