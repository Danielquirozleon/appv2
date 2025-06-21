document.addEventListener("DOMContentLoaded", function () {
    const clienteSelect = document.getElementById("numero_cliente");
    const direccionSelect = document.getElementById("direccion");

    if (clienteSelect && direccionSelect) {
        clienteSelect.addEventListener("change", function () {
            const clienteId = this.value;

            if (clienteId) {
                fetch(`/controllers/DireccionController.php?action=obtenerDirecciones&numero_cliente=${clienteId}`)
                    .then(response => response.json())
                    .then(data => {
                        direccionSelect.innerHTML = '<option value="">Selecciona una dirección</option>';
                        data.forEach(dir => {
                            direccionSelect.innerHTML += `<option value="${dir.id}">${dir.direccion}</option>`;
                        });
                    })
                    .catch(err => {
                        console.error("Error al cargar direcciones:", err);
                        direccionSelect.innerHTML = '<option value="">Error al cargar direcciones</option>';
                    });
            } else {
                direccionSelect.innerHTML = '<option value="">Selecciona un cliente primero</option>';
            }
        });
    }
});
