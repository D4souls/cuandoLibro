function eliminarUsuario() {
    Swal.fire({
        title: "¿Estás intentando borrarte?",
        icon: "question",
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
}
function saveChanges() {
    Swal.fire({
        title: "Cambios aplicados",
        icon: "success",
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
}