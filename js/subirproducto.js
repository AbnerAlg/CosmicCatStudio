// Aquí se almacenará el JSON generado desde PHP
const productoData = window.productoData || null;

document.addEventListener('DOMContentLoaded', () => {
    if (productoData) {
        document.getElementById('producto-imagen').src = `data:${productoData.imagen.type};base64,${productoData.imagen.data}`;
        document.getElementById('producto-nombre').innerHTML = `<strong>Nombre:</strong> ${productoData.nombre}`;
        document.getElementById('producto-descripcion').innerHTML = `<strong>Descripción:</strong> ${productoData.descripcion}`;
        document.getElementById('producto-precio').innerHTML = `<strong>Precio:</strong> $${productoData.precio}`;
    }
});
