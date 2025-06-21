document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("archivo_importacion");
    const form = document.getElementById("form_importacion");
    const archivoLabel = document.getElementById("archivo_label");

    if (fileInput && form) {
        // Mostrar nombre del archivo seleccionado
        fileInput.addEventListener("change", function () {
            const archivo = fileInput.files[0];

            if (archivo) {
                archivoLabel.textContent = archivo.name;

                const extension = archivo.name.split('.').pop().toLowerCase();
                if (!["txt", "xlsx"].includes(extension)) {
                    alert("Formato no permitido. Solo se aceptan archivos .txt o .xlsx");
                    fileInput.value = ""; // limpia el input
                    archivoLabel.textContent = "Selecciona un archivo...";
                    return;
                }
            }
        });

        // Validación al enviar el formulario
        form.addEventListener("submit", function (e) {
            if (!fileInput.files[0]) {
                e.preventDefault();
                alert("Por favor selecciona un archivo antes de importar.");
                return;
            }

            const confirmar = confirm("¿Estás seguro de que deseas importar este archivo? Esta acción reemplazará los datos actuales.");
            if (!confirmar) {
                e.preventDefault();
            }
        });
    }
});
