document.addEventListener('DOMContentLoaded', function() {
    const idOyente = new URLSearchParams(window.location.search).get('id');
    cargarTodosLosArtistas();

    async function cargarTodosLosArtistas() {
        try {
            const response = await fetch('../php5/obtener_todos_los_artistas.php'); // Archivo PHP que obtiene todos los artistas
            const artistas = await response.json();
            const contenedorArtistas = document.getElementById('contenedor-artistas');
            contenedorArtistas.innerHTML = ''; // Limpiar el contenedor antes de agregar artistas

            artistas.forEach(artista => {
                const divArtista = document.createElement('a');
                divArtista.href = `profile_view.php?id=${idOyente}&idart=${artista.idartista}`;
                divArtista.classList.add('sin-mod');
                divArtista.innerHTML = `
                    <div class="cancion">
                        <img class="musica-imagen imagen-artista" src="data:${artista.tipo_avatar};base64,${artista.avatar}" alt="${artista.nombre_artistico}">
                        <p class="musica-titulo letra centrar">${artista.nombre_artistico}</p>
                    </div>
                `;
                contenedorArtistas.appendChild(divArtista);
            });
        } catch (error) {
            console.error('Error al cargar los artistas:', error);
        }
    }
});
