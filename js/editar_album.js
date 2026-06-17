document.addEventListener('DOMContentLoaded', async function() {
    const id_album = new URLSearchParams(window.location.search).get('id_album');
    const id_artista = new URLSearchParams(window.location.search).get('id');

    let base64Foto = null;

    // Vista previa y codificación de imagen del álbum en Base64
    document.getElementById('foto-album').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            base64Foto = reader.result.split(',')[1]; // Codificación en Base64 sin el encabezado
            const preview = document.getElementById('vista-previa');
            preview.src = reader.result;
            preview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    // Función para cargar información del álbum y canciones
    async function cargarDatosAlbum() {
        const response = await fetch(`../php5/obtener_album_detalles.php?id_album=${id_album}`);
        const album = await response.json();

        // Rellenar formulario con datos del álbum
        document.getElementById('nombre-album').value = album.nombre;
        document.getElementById('descripcion-album').value = album.descripcion;
        document.getElementById('vista-previa').src = `data:${album.tipo_foto};base64,${album.foto}`;
        document.getElementById('vista-previa').style.display = 'block';

        cargarCancionesEnAlbum();
        cargarCancionesSinAlbum();
    }

    // Cargar canciones asociadas al álbum
    async function cargarCancionesEnAlbum() {
        const response = await fetch(`../php5/obtener_canciones_album.php?id_album=${id_album}`);
        const cancionesAlbum = await response.json();
        const listaCancionesAlbum = document.getElementById('lista-canciones-album');
        listaCancionesAlbum.innerHTML = '';

        cancionesAlbum.forEach(cancion => {
            const cancionDiv = document.createElement('div');
            cancionDiv.classList.add('cancion-item');
            cancionDiv.innerHTML = `
                <img src="data:${cancion.tipo_foto};base64,${cancion.foto}" alt="Foto de canción">
                <p>${cancion.titulo}</p>
                <button type="button" onclick="eliminarCancionDelAlbum(${cancion.id_musica})">Eliminar</button>
            `;
            listaCancionesAlbum.appendChild(cancionDiv);
        });
    }

    // Cargar canciones sin ningún álbum
    async function cargarCancionesSinAlbum() {
        const response = await fetch(`../php5/obtener_canciones_sin_album.php?id_artista=${id_artista}`);
        const cancionesSinAlbum = await response.json();
        const listaCancionesNoAlbum = document.getElementById('lista-canciones-no-album');
        listaCancionesNoAlbum.innerHTML = '';

        cancionesSinAlbum.forEach(cancion => {
            const cancionDiv = document.createElement('div');
            cancionDiv.classList.add('cancion-item');
            cancionDiv.innerHTML = `
                <img src="data:${cancion.tipo_foto};base64,${cancion.foto}" alt="Foto de canción">
                <p>${cancion.nombre}</p>
                <button type="button" onclick="agregarCancionAlAlbum(${cancion.id_musica})">Agregar al Álbum</button>
            `;
            listaCancionesNoAlbum.appendChild(cancionDiv);
        });
    }

    // Función para guardar cambios en el álbum
    window.guardarCambiosAlbum = async function() {
        const albumData = {
            id_album: id_album,
            nombre_album: document.getElementById('nombre-album').value,
            descripcion: document.getElementById('descripcion-album').value,
            foto: base64Foto // Enviar la imagen en Base64 si existe
        };

        const response = await fetch('../php5/guardar_cambios_album.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(albumData)
        });

        const result = await response.json();
        if (result.success) {
            alert('Álbum actualizado con éxito');
            setTimeout(() => {
                const id_artista = new URLSearchParams(window.location.search).get('id');
                window.location.href = `profile.php?id=${id_artista}`;
            }, 2000);
        } else {
            alert('Error al actualizar el álbum');
        }
    };

    // Función para eliminar una canción del álbum
    window.eliminarCancionDelAlbum = async function(id_musica) {
        const response = await fetch(`../php5/eliminar_cancion_album.php?id_album=${id_album}&id_musica=${id_musica}`, {
            method: 'DELETE'
        });

        const result = await response.json();
        if (result.success) {
            cargarCancionesEnAlbum(); // Recargar canciones del álbum
            cargarCancionesSinAlbum(); // Recargar canciones sin álbum
        } else {
            alert('Error al eliminar la canción');
        }
    };

    // Función para agregar una canción al álbum
    window.agregarCancionAlAlbum = async function(id_musica) {
        const response = await fetch(`../php5/agregar_cancion_album.php?id_album=${id_album}&id_musica=${id_musica}`, {
            method: 'POST'
        });

        const result = await response.json();
        if (result.success) {
            cargarCancionesEnAlbum(); // Recargar canciones del álbum
            cargarCancionesSinAlbum(); // Recargar canciones sin álbum
        } else {
            alert('Error al agregar la canción');
        }
    };

    // Cargar datos iniciales del álbum
    cargarDatosAlbum();
});
