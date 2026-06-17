document.addEventListener('DOMContentLoaded', async function() {
    const contenedorAlbum = document.getElementById('contenedor-canciones-albums');
    const id_artista = new URLSearchParams(window.location.search).get('id');
    let id_musica_seleccionada;

    // Cargar canciones del artista
    async function cargarCanciones() {
        const response = await fetch(`../php5/obtener_canciones_artista.php?id_artista=${id_artista}`);
        const canciones = await response.json();
        contenedorAlbum.innerHTML = '';

        canciones.forEach(cancion => {
            const divImagen = document.createElement('div');
            divImagen.classList.add('contenedor-imagen');
            divImagen.innerHTML = `
                <a href="" onclick="event.preventDefault();">
                    <img class="imagen" src="data:${cancion.tipo_foto};base64,${cancion.foto}" alt="Imagen de canción">
                    <div class="overlay-iconos">
                        <div class="icono" id="icono-uno">
                            <a href="musica-modificar.php?id_artista=${id_artista}&id_musica=${cancion.id_musica}" 
                               class="sin-mod icono-cancion icono-editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" viewBox="0 0 24 24" fill="none" 
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                    <path d="M13.5 6.5l4 4" />
                                    <path d="M16 19h6" />
                                </svg>
                            </a>
                        </div>
                        <div class="icono" id="icono-dos">
                            <a href="" class="sin-mod icono-cancion icono-eliminar" onclick="mostrarModal(event, ${cancion.id_musica})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" viewBox="0 0 24 24" fill="none" 
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M9 12l6 0" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </a>
            `;
            contenedorAlbum.appendChild(divImagen);
        });

        document.getElementById('subir-musica-btn').style.display = 'block';
        document.getElementById('crear-album-btn').style.display = 'none';
    }

    // Cargar álbums del artista
    async function cargarAlbums() {
        const response = await fetch(`../php5/obtener_albums_artista.php?id_artista=${id_artista}`);
        const albums = await response.json();
        contenedorAlbum.innerHTML = '';

        if (albums.length === 0) {
            contenedorAlbum.innerHTML = `<p>No tienes Álbums. ¿Quieres crear uno?</p>`;
        } else {
            albums.forEach(album => {
                const divAlbum = document.createElement('div');
                divAlbum.classList.add('contenedor-imagen');
                divAlbum.innerHTML = `
                    <a href="" onclick="event.preventDefault();">
                        <img class="imagen" src="data:${album.tipo_foto};base64,${album.foto}" alt="Imagen de álbum">
                        <div class="overlay-iconos">
                            <div class="icono" id="icono-uno">
                                <a href="editar_album.php?id=${id_artista}&id_album=${album.id_album}" 
                                   class="sin-mod icono-cancion icono-editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" viewBox="0 0 24 24" fill="none" 
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                        <path d="M13.5 6.5l4 4" />
                                        <path d="M16 19h6" />
                                    </svg>
                                </a>
                            </div>
                            <div class="icono" id="icono-dos">
                                <a href="" class="sin-mod icono-cancion icono-eliminar" onclick="mostrarModalAlbum(event, ${album.id_album})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" viewBox="0 0 24 24" fill="none" 
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M9 12l6 0" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </a>
                `;
                contenedorAlbum.appendChild(divAlbum);
            });
        }

        document.getElementById('crear-album-btn').style.display = 'block';
        document.getElementById('subir-musica-btn').style.display = 'none';
    }

    window.mostrarCanciones = function() {
        cargarCanciones();
    };

    window.mostrarAlbums = function() {
        cargarAlbums();
    };

    window.mostrarModal = function(event, id_musica) {
        event.preventDefault();
        id_musica_seleccionada = id_musica;
        document.getElementById('overlay-eliminar').style.display = 'flex';
    };

    document.getElementById('confirmar-eliminar').addEventListener('click', async () => {
        await eliminarCancion(id_musica_seleccionada);
        document.getElementById('overlay-eliminar').style.display = 'none';
        cargarCanciones();
    });

    document.getElementById('cancelar-eliminar').addEventListener('click', () => {
        document.getElementById('overlay-eliminar').style.display = 'none';
    });

    async function eliminarCancion(id_musica) {
        const formData = new FormData();
        formData.append('id_musica', id_musica);

        await fetch('../php5/eliminar_cancion.php', {
            method: 'POST',
            body: formData
        });
    }

    cargarCanciones();
});
