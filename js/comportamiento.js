/* Este comportamiendo se cumple cuando la descripción del producto es muy larga
   sale un 'ver mas' para ver el contenido.*/ 

function toggleDescripcion(id) {
    const descripcion = document.getElementById(id);
    if (descripcion.style.maxHeight) {
        descripcion.style.maxHeight = null;
        descripcion.style.overflow = 'hidden';
    } else {
        descripcion.style.maxHeight = '100em'; 
        descripcion.style.overflow = 'visible';
    }
}

// Función para comprobar si mostrar "Ver más"
function mostrarVerMas() {
    const descripcion = document.getElementById('descripcion-1');
    const verMas = document.getElementById('ver-mas-1');

    // Esto se ajusta a un cierto numero de acaracteres
    const limiteCaracteres = 100; 

    if (descripcion.textContent.length > limiteCaracteres) {
        verMas.style.display = 'block'; // Muestra el enlace "Ver más"
    } else {
        verMas.style.display = 'none'; // Oculta el enlace
    }
}

// Por ultimo llama a la función al cargar la página
window.onload = mostrarVerMas;

// Modal de confirmación
function mostrarModal(event) {
    event.preventDefault();
    alert("¿Estás seguro de que deseas eliminar este producto?");
}
