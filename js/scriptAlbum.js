let isPlaying = false;
const audio = document.getElementById("audio");

function reproducirCancion(cancion) {
    const barraProgreso = document.getElementById("barra-progreso");
    const tiempoActual = document.getElementById("tiempo-actual");
    const duracion = document.getElementById("duracion");

    audio.src = `data:${cancion.tipo_audio};base64,${cancion.archivo}`;
    audio.play();

    document.getElementById("tituloReproduccion").textContent = cancion.titulo;
    document.getElementById("reproductorPortada").src = `data:${cancion.tipo_foto};base64,${cancion.foto}`;

    audio.addEventListener("loadedmetadata", () => {
        duracion.textContent = formatTime(audio.duration);
        barraProgreso.max = Math.floor(audio.duration);
    });

    audio.addEventListener("timeupdate", () => {
        barraProgreso.value = Math.floor(audio.currentTime);
        tiempoActual.textContent = formatTime(audio.currentTime);
    });

    barraProgreso.addEventListener("input", () => {
        audio.currentTime = barraProgreso.value;
    });

    document.getElementById("play-icon").style.display = "none";
    document.getElementById("pause-icon").style.display = "inline";
    isPlaying = true;

    // Incrementar la reproducción de la canción
    incrementarReproduccion(cancion.id_musica);
}


function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
}

document.getElementById("play-pause").addEventListener("click", () => {
    const playIcon = document.getElementById("play-icon");
    const pauseIcon = document.getElementById("pause-icon");

    if (isPlaying) {
        audio.pause();
        playIcon.style.display = "inline";
        pauseIcon.style.display = "none";
    } else {
        audio.play();
        playIcon.style.display = "none";
        pauseIcon.style.display = "inline";
    }
    isPlaying = !isPlaying;
});

document.addEventListener("DOMContentLoaded", function () {
    const idAlbum = new URLSearchParams(window.location.search).get('id_album');
    const contenedorCanciones = document.getElementById("contenedor-canciones");

    // Cargar detalles del álbum
    fetch(`../php5/obtener_album_detalles.php?id_album=${idAlbum}`)
        .then(response => {
            if (!response.ok) throw new Error("Error en la respuesta del servidor");
            return response.json();
        })
        .then(album => {
            if (album.error) throw new Error(album.error);
            document.getElementById("tituloAlbum").textContent = album.nombre;
            document.getElementById("fotoAlbum").src = `data:${album.tipo_foto};base64,${album.foto}`;

            // Cargar canciones del álbum
            fetch(`../php5/obtener_cancione_album.php?id_album=${idAlbum}`)
                .then(response => {
                    if (!response.ok) throw new Error("Error en la respuesta del servidor para canciones");
                    return response.json();
                })
                .then(canciones => {
                    if (!Array.isArray(canciones)) throw new Error("Formato inesperado en las canciones");
                    contenedorCanciones.innerHTML = canciones.map(cancion => `
                        <div class="cancion-item" onclick="reproducirCancion({ 
                            id_musica: ${cancion.id_musica},
                            titulo: '${cancion.titulo}', 
                            tipo_audio: '${cancion.tipo_audio}', 
                            archivo: '${cancion.archivo}', 
                            artista: '${cancion.artista}', 
                            tipo_foto: '${cancion.tipo_foto}', 
                            foto: '${cancion.foto}' 
                        })">
                            <img src="data:${cancion.tipo_foto};base64,${cancion.foto}" alt="Foto canción">
                            <p>${cancion.titulo}</p>
                        </div>
                    `).join('');
                })
                .catch(error => {
                    console.error("Error al cargar canciones:", error);
                    contenedorCanciones.innerHTML = "<p>Error al cargar las canciones.</p>";
                });
        })
        .catch(error => {
            console.error("Error al cargar álbum:", error);
            document.getElementById("tituloAlbum").textContent = "Error al cargar el álbum";
        });
});

async function incrementarReproduccion(id_musica) {
    const id_oyente = new URLSearchParams(window.location.search).get('id');
    try {
        await fetch(`../php5/incrementar_reproduccion.php?id_musica=${id_musica}&id_oyente=${id_oyente}`, { method: 'POST' });
    } catch (error) {
        console.error('Error al incrementar la reproducción:', error);
    }
}

