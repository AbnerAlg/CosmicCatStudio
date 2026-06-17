document.addEventListener('DOMContentLoaded', function() {
    cargarHistorialCompleto();

    async function cargarHistorialCompleto() {
        const urlParams = new URLSearchParams(window.location.search);
        const id_oyente = urlParams.get('id');

        const response = await fetch(`../php5/obtener_historial_completo.php?id_oyente=${id_oyente}`);
        const canciones = await response.json();
        
        const contenedorHistorial = document.getElementById('contenedor-historial');
        contenedorHistorial.innerHTML = ''; 

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

    // Reproductor de música
    const audio = document.getElementById('audio');
    const playPauseButton = document.getElementById('play-pause');
    const barraProgreso = document.getElementById('barra-progreso');
    const tiempoActualEl = document.getElementById('tiempo-actual');
    const duracionEl = document.getElementById('duracion');
    let isPlaying = false;

    let idMusicaActual = null; // Variable para almacenar el id de la canción actual

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
        });

        updatePlayPauseButton();
        incrementarReproduccion(id_musica); // Incrementa el conteo de reproducciones
    }
}

    function updateProgressBar() {
        if (audio.duration) {
            const progreso = (audio.currentTime / audio.duration) * 100;
            barraProgreso.value = progreso;
            tiempoActualEl.textContent = formatearTiempo(audio.currentTime);
        }
    }

    function updatePlayPauseButton() {
        playPauseButton.innerHTML = isPlaying ? 
        `<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M9 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z"/>
            <path d="M17 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z"/>
        </svg>` :
        `<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M7 4v16l13 -8z"/>
        </svg>`;
    }

    function formatearTiempo(segundos) {
        const minutos = Math.floor(segundos / 60);
        const segundosRestantes = Math.floor(segundos % 60);
        return `${minutos}:${segundosRestantes < 10 ? '0' : ''}${segundosRestantes}`;
    }

    async function incrementarReproduccion(id_musica) {
        const id_oye = new URLSearchParams(window.location.search).get('id');
        try {
            await fetch(`../php5/incrementar_reproduccion.php?id_musica=${id_musica}&id_oyente=${id_oye}`, { method: 'POST' });
        } catch (error) {
            console.error('Error al incrementar la reproducción:', error);
        }
    }

    playPauseButton.addEventListener('click', () => {
        if (isPlaying) {
            audio.pause();
        } else {
            audio.play();
        }
        isPlaying = !isPlaying;
        updatePlayPauseButton();
    });

    barraProgreso.addEventListener('input', function() {
        const nuevaPosicion = (this.value / 100) * audio.duration;
        audio.currentTime = nuevaPosicion;
    });
});
