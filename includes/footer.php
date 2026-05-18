</div>

<!-- MODAL GLOBAL -->

<div id="modalConfirmacion" class="modal-overlay">

<div class="modal-box">

<h3 class="text-xl font-bold mb-4">
Confirmar acción
</h3>

<p id="textoModal" class="mb-6">
¿Deseas continuar?
</p>

<div class="flex justify-end gap-3">

<button id="cancelarModal" class="btn btn-gray">
Cancelar
</button>

<button id="aceptarModal" class="btn btn-red">
Eliminar
</button>

</div>

</div>

</div>

<footer class="bg-gray-900 text-white text-center p-5 mt-10">

<p>
StudySpace © <?= date("Y") ?>
</p>

</footer>

<script>

window.modalCallback = null;

function abrirModal(texto, callback) {

    document.getElementById("textoModal").innerText = texto;

    document.getElementById("modalConfirmacion").style.display = "flex";

    window.modalCallback = callback;
}

document.getElementById("cancelarModal")
.addEventListener("click", () => {

    document.getElementById("modalConfirmacion").style.display = "none";
});

document.getElementById("aceptarModal")
.addEventListener("click", () => {

    document.getElementById("modalConfirmacion").style.display = "none";

    if (window.modalCallback) {
        window.modalCallback();
    }
});

</script>

</body>
</html>