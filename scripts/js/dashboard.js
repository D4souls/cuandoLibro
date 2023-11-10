function redirigirUserEdit(dni) {
  window.location.href = `#userEdit?dni=${dni}`;
}
document.addEventListener("DOMContentLoaded", function () {
    const body = document.querySelector("body"),
      sidebar = body.querySelector(".sidebar"),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toogle-switch"),
      modeText = body.querySelector(".mode-text"),
      abrirModal = document.querySelector("#abrirModal");
  
    toggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
    });
  
    searchBtn.addEventListener("click", () => {
      sidebar.classList.remove("close");
    });
  
    modeSwitch.addEventListener("click", () => {
      body.classList.toggle("dark");
  
      if (body.classList.contains("dark")) {
        modeText.innerText = "Modo claro";
      } else {
        modeText.innerText = "Modo oscuro";
      }
    });
  
    abrirModal.addEventListener("click", () => {
        dialogo.showModal()
      // Aquí deberías tener la lógica para abrir el modal
      // Puedes usar `dialogo.showModal();` si estás utilizando un dialogo HTML5
    });
  
    const botonMostrar = document.getElementById("mostrarDialogo");
    const dialogo = document.getElementById("miDialogo");
    const botonCerrar = document.getElementById("cerrarDialogo");
  
    botonMostrar.addEventListener("click", () => {
      // Abre el diálogo
      dialogo.showModal();
    });
  
    // Agrega un evento de clic al botón de cerrar
    botonCerrar.addEventListener("click", () => {
      // Cierra el diálogo
      dialogo.close();
    });
  });
  