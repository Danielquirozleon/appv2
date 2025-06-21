document.addEventListener("DOMContentLoaded", function () {
    const productoInput = document.getElementById("PRODUCT_ID");
    const nombreInput = document.getElementById("PRODUCT_NAME");
    const descripcionInput = document.getElementById("DESCRIPTION");
    const unidadInput = document.getElementById("UM");

    if (productoInput) {
        productoInput.addEventListener("change", function () {
            const productId = this.value.trim();

            if (productId !== "") {
                fetch(`/controllers/ProductoController.php?action=buscar&PRODUCT_ID=${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.exists) {
                            nombreInput.value = data.PRODUCT_NAME || "";
                            descripcionInput.value = data.DESCRIPTION || "";
                            unidadInput.value = data.UM || "";
                        } else {
                            nombreInput.value = "";
                            descripcionInput.value = "";
                            unidadInput.value = "";
                            alert("Producto no encontrado.");
                        }
                    })
                    .catch(err => {
                        console.error("Error al buscar producto:", err);
                        alert("Error al buscar producto.");
                    });
            }
        });
    }
});
