document.addEventListener("DOMContentLoaded", function () {
    const alertas = document.querySelectorAll(".alert");

    alertas.forEach(alerta => {
        setTimeout(() => {
            alerta.classList.add("ocultar");
            alerta.remove();
        }, 4000); // Se elimina después de 4 segundos
    });
});
