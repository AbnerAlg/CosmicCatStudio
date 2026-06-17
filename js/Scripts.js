// Obtener los elementos del DOM
const audio = document.getElementById('audio');
const playPauseButton = document.getElementById('play-pause');
const barraProgreso = document.getElementById('barra-progreso');
const tiempoActualEl = document.getElementById('tiempo-actual');
const duracionEl = document.getElementById('duracion');
const skipBackwardButton = document.getElementById('skip-backward');
const skipForwardButton = document.getElementById('skip-forward');

// Variables de estado
let isPlaying = false;
const id_oyente = new URLSearchParams(window.location.search).get('id');
let cancionesLista = []; // Lista de todas las canciones cargadas
let cancionActualIndex = 0; // Índice de la canción actual en la lista
let idMusicaActual = null; // ID de la canción actualmente en reproducción

// Función para actualizar la barra de progreso
function updateProgressBar() {
    if (audio.duration) {
        const progreso = (audio.currentTime / audio.duration) * 100;
        barraProgreso.value = progreso;
    }
    tiempoActualEl.textContent = formatearTiempo(audio.currentTime);
}


// Alternar entre pausar y reproducir
playPauseButton.addEventListener('click', () => {
    if (isPlaying) {
        audio.pause();
    } else {
        audio.play();
    }
    isPlaying = !isPlaying;
    updatePlayPauseButton();
});

// Actualizar el botón de reproducir/pausar
function updatePlayPauseButton() {
    if (isPlaying) {
        playPauseButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M9 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z"/>
                <path d="M17 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z"/>
            </svg>`;
    } else {
        playPauseButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M7 4v16l13 -8z"/>
            </svg>`;
    }
}

// Función para formatear el tiempo
function formatearTiempo(segundos) {
    const minutos = Math.floor(segundos / 60);
    const segundosRestantes = Math.floor(segundos % 60);
    return `${minutos}:${segundosRestantes < 10 ? '0' : ''}${segundosRestantes}`;
}

// Mover la barra de progreso al hacer cambios en ella
barraProgreso.addEventListener('input', function() {
    const nuevaPosicion = (this.value / 100) * audio.duration;
    audio.currentTime = nuevaPosicion;
});

document.addEventListener('DOMContentLoaded', function() {
    const idOyente = new URLSearchParams(window.location.search).get('id');
    cargarTodasLasCanciones();
    cargarRecomendaciones();
    cargarHistorial();
    cargarArtistas();
    cargarAlbums();

    async function cargarTodasLasCanciones() {
        const response = await fetch('../php5/obtener_todas_canciones.php'); // PHP para obtener todas las canciones
        cancionesLista = await response.json();
    }

    async function cargarRecomendaciones() {
        const response = await fetch('../php5/obtener_recomendaciones.php');
        const canciones = await response.json();
        
        const contenedorRecomendaciones = document.getElementById('contenedor-recomendaciones');
        contenedorRecomendaciones.innerHTML = ''; // Limpia las recomendaciones anteriores

        canciones.forEach(cancion => {
            const divCancion = document.createElement('div');
            divCancion.classList.add('cancion');
            divCancion.innerHTML = `
                <img class="musica-imagen" src="data:${cancion.tipo_foto};base64,${cancion.foto}" alt="musica">
                <p class="musica-titulo letra">${cancion.titulo}</p>
                <p class="musica-autor letra">${cancion.nombre_artistico}</p>
            `;
            divCancion.addEventListener('click', () => {
                reproducirCancion(
                    `data:${cancion.tipo_audio};base64,${cancion.archivo}`, 
                    cancion.titulo, 
                    cancion.nombre_artistico, 
                    `data:${cancion.tipo_foto};base64,${cancion.foto}`,
                    cancion.id_musica
                );
            });
            contenedorRecomendaciones.appendChild(divCancion);
        });
    }

    async function reproducirCancion(ruta, titulo, autor, portada, id_musica) {
        if (id_musica === idMusicaActual) {
            // Si es la misma canción, alterna entre pausar y reproducir
            if (isPlaying) {
                audio.pause();
            } else {
                audio.play();
            }
            isPlaying = !isPlaying;
            updatePlayPauseButton();
        } else {
            // Si es una canción diferente, actualiza la ruta de audio y comienza a reproducir
            audio.src = ruta;
            audio.play();
            isPlaying = true;
            idMusicaActual = id_musica; // Actualiza idMusicaActual al nuevo id

            // Actualizar la información de la canción en el reproductor
            document.querySelector('.titulo-cancion').innerText = titulo;
            document.querySelector('.artista-cancion').innerText = autor;
            document.querySelector('.portada').src = portada;

            // Actualizar metadatos y eventos del reproductor
            audio.addEventListener('loadedmetadata', () => {
                duracionEl.textContent = formatearTiempo(audio.duration);
                updateProgressBar();
            });
            audio.addEventListener('timeupdate', updateProgressBar);
            audio.addEventListener('ended', () => {
                isPlaying = false;
                updatePlayPauseButton();
                siguienteCancion(); // Avanza automáticamente al terminar
            });

            updatePlayPauseButton();
            incrementarReproduccion(id_musica); // Incrementa el conteo de reproducciones

            // Establecer el índice actual en la lista global
            cancionActualIndex = cancionesLista.findIndex(c => c.id_musica === id_musica);
        }
    }

    // Función para avanzar a la siguiente canción
    function siguienteCancion() {
        cancionActualIndex = (cancionActualIndex + 1) % cancionesLista.length;
        const cancion = cancionesLista[cancionActualIndex];
        reproducirCancion(
            `data:${cancion.tipo_audio};base64,${cancion.archivo}`, 
            cancion.titulo, 
            cancion.nombre_artistico, 
            `data:${cancion.tipo_foto};base64,${cancion.foto}`, 
            cancion.id_musica
        );
    }

    // Función para retroceder a la canción anterior
    function retrocederCancion() {
        cancionActualIndex = (cancionActualIndex - 1 + cancionesLista.length) % cancionesLista.length;
        const cancion = cancionesLista[cancionActualIndex];
        reproducirCancion(
            `data:${cancion.tipo_audio};base64,${cancion.archivo}`, 
            cancion.titulo, 
            cancion.nombre_artistico, 
            `data:${cancion.tipo_foto};base64,${cancion.foto}`, 
            cancion.id_musica
        );
    }

    // Configurar eventos de los botones de avance y retroceso
    skipBackwardButton.addEventListener('click', retrocederCancion);
    skipForwardButton.addEventListener('click', siguienteCancion);

    async function cargarArtistas() {
        try {
            const response = await fetch('../php5/obtener_artistas.php');
            const artistas = await response.json();
            const contenedorArtistas = document.getElementById('contenedor-artistas');
    
            contenedorArtistas.innerHTML = ''; // Limpiar el contenedor anterior
    
            artistas.forEach(artista => {
                const divArtista = document.createElement('div');
                divArtista.classList.add('sin-mod');
                divArtista.innerHTML = `
                    <div class="cancion">
                        <img class="musica-imagen imagen-artista" src="data:${artista.tipo_avatar};base64,${artista.avatar}" alt="${artista.nombre_artistico}">
                        <p class="musica-titulo letra centrar">${artista.nombre_artistico}</p>
                    </div>
                `;
                divArtista.addEventListener('click', () => redirigirAlPerfil(artista.idartista));
                contenedorArtistas.appendChild(divArtista);
            });
        } catch (error) {
            console.error('Error al cargar los artistas:', error);
        }
    }

    function redirigirAlPerfil(id_artista) {
        const id_oyente = new URLSearchParams(window.location.search).get('id');
    
        // Realizar el fetch para incrementar la visita
        fetch(`../php5/sumar_visita.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_oyente, id_artista })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redireccionar al perfil del artista con los parámetros en la URL
                window.location.href = `../html/profile_view.php?id=${id_oyente}&idart=${id_artista}`;
            } else {
                console.error('Error al sumar la visita:', data.message);
            }
        })
        .catch(error => {
            console.error('Error al sumar la visita:', error);
        });
    }

    async function incrementarReproduccion(id_musica) {
        try {
            await fetch(`../php5/incrementar_reproduccion.php?id_musica=${id_musica}&id_oyente=${id_oyente}`, { method: 'POST' });
        } catch (error) {
            console.error('Error al incrementar la reproducción:', error);
        }
    }

    async function cargarHistorial() {
        const urlParams = new URLSearchParams(window.location.search);
        const id_oyente = urlParams.get('id'); // Obtener el id_oyente de la URL

        const response = await fetch(`../php5/obtener_historial.php?id_oyente=${id_oyente}`);
        const canciones = await response.json();
        
        const contenedorHistorial = document.querySelector('.lista-canciones');
        contenedorHistorial.innerHTML = ''; // Limpia el contenido previo

        canciones.forEach(cancion => {
            const divCancion = document.createElement('div');
            divCancion.classList.add('cancion');
            divCancion.innerHTML = `
                <img class="musica-imagen" src="data:${cancion.tipo_foto};base64,${cancion.foto}" alt="musica">
                <p class="musica-titulo letra">${cancion.titulo}</p>
                <p class="musica-autor letra">${cancion.nombre_artistico}</p>
            `;
            divCancion.addEventListener('click', () => {
                reproducirCancion(
                    `data:${cancion.tipo_audio};base64,${cancion.archivo}`, 
                    cancion.titulo, 
                    cancion.nombre_artistico, 
                    `data:${cancion.tipo_foto};base64,${cancion.foto}`,
                    cancion.id_musica
                );
            });
            contenedorHistorial.appendChild(divCancion);
        });
    }
});



async function cargarAlbums() {
    try {
        const response = await fetch('../php5/obtener_albums.php');
        const albums = await response.json();
        const contenedorAlbums = document.getElementById('contenedor-albums');
        contenedorAlbums.innerHTML = ''; // Limpia el contenido previo

        albums.forEach(album => {
            const divAlbum = document.createElement('div');
            divAlbum.classList.add('cancion');
            divAlbum.innerHTML = `
                <img class="musica-imagen" src="data:${album.tipo_foto};base64,${album.foto}" alt="${album.nombre}">
                <p class="musica-titulo letra">${album.nombre}</p>
                <p class="musica-autor letra">${album.nombre_artistico}</p>
            `;
            divAlbum.addEventListener('click', () => {
                window.location.href = `album_completo.php?id=${idAr}&id_album=${album.id_album}`;
            });
            contenedorAlbums.appendChild(divAlbum);
        });
    } catch (error) {
        console.error('Error al cargar los álbums:', error);
    }
}
