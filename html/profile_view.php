<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Artista</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/reproductor.css">
</head>

<body>
    <script>
        const idAr = new URLSearchParams(window.location.search).get('id');

        function irAPagina(url) {
            window.location.href = url + `?id=${idAr}`;
        }

        function irAPagina2(url) {
            window.location.href = url;
        }
    </script>
    <header>
        <div class="contenedor-header">
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt=""></a></h1>
            <nav class="navegacion">
                <a class="sin-mod" href="#">Musica</a>
                <a class="sin-mod" href="#" onclick="event.preventDefault();irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="#" onclick="event.preventDefault();irAPagina('comunidad.php')">Mi Comunidad</a>
                <a class="sin-mod" href="#"
                    onclick="event.preventDefault();irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-perfil">
            <div class="contenedor-banner">
                <img id="bannerImage" class="banner" src="">
            </div>

            <div class="contenedor-foto-perfil">
                <img id="avatarImage" class="foto-perfil" src="">
            </div>

            <h2 id="nombreArtista" class="nombre">Nombre Artista</h2>
            <button id="followButton" class="seguir-boton" onclick="toggleFollow()">Seguir</button>

            <p id="descripcionArtista" class="descripcion-artista">Descripción del artista...</p>

            <div class="contenedor-estadisticas contenedor-estadisticas-vista">
                <div class="estadistica">
                    <p class="estadistica-dato"><strong id="seguidores">0</strong></p>
                    <p>Seguidores</p>
                </div>
                <div class="estadistica">
                    <p class="estadistica-dato"><strong id="oyentes">0</strong></p>
                    <p>Oyentes</p>
                </div>
                <div class="estadistica">
                    <p class="estadistica-dato"><strong id="lanzamientos">0</strong></p>
                    <p>Lanzamientos</p>
                </div>
            </div>

            <!-- Botones de vista de canciones o álbumes -->
            <div class="encabezado-vista">
                <button class="boton-vista" onclick="mostrarCanciones()">Canciones</button>
                <button class="boton-vista" onclick="mostrarAlbums()">Álbums</button>
            </div>

            <!-- Contenedor dinámico de canciones o álbumes -->
            <div class="contenedor-canciones-albums" id="contenedor-canciones-albums">
                <!-- Aquí se cargarán las canciones o álbumes del artista -->
            </div>
        </div>
    </main>

    <!-- Reproductor de música fijado -->
    <div class="reproductor-musica">
        <div class="info-cancion">
            <img src="../img/MUSICA1.jpg" alt="Portada del álbum" class="portada">
            <div class="detalles-cancion">
                <p class="titulo-cancion" id="tituloReproduccion">Título Canción</p>
                <p class="artista-cancion">Artista Canción</p>
            </div>
        </div>
        <div class="medio-reproductor">
            <input type="range" id="barra-progreso" value="0" max="100" class="barra-progreso">
            <div class="tiempo">
                <span id="tiempo-actual">0:00</span> / <span id="duracion">0:00</span>
            </div>
            <div class="controles-reproductor">
                <button class="boton-control" id="skip-backward">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path d="M10 12L18 6v12l-8-6zm-8 6V6h2v12H2z" />
                    </svg>
                </button>
                <button class="boton-control" id="play-pause">
                    <svg width="24" height="24" id="play-icon" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                    <svg width="24" height="24" id="pause-icon" viewBox="0 0 24 24" style="display: none;">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                    </svg>
                </button>
                <button class="boton-control" id="skip-forward">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path d="M6 18l8-6-8-6v12zm14-12h-2v12h2V6z" />
                    </svg>
                </button>
            </div>
        </div>
        <audio id="audio"></audio>
    </div>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const idOyente = new URLSearchParams(window.location.search).get('id');
            const idArtista = new URLSearchParams(window.location.search).get('idart');
            const followButton = document.getElementById("followButton");
            const audio = document.getElementById("audio");
            const barraProgreso = document.getElementById("barra-progreso");
            const tiempoActual = document.getElementById("tiempo-actual");
            const duracion = document.getElementById("duracion");
            let isPlaying = false;

            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
            }

            // Cargar perfil del artista
            fetch(`../php5/ver_perfil.php?id=${idOyente}&idart=${idArtista}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("nombreArtista").textContent = data.nombre_artistico;
                    document.getElementById("avatarImage").src = `data:${data.avatar.type};base64,${data.avatar.data}`;
                    document.getElementById("bannerImage").src = `data:${data.banner.type};base64,${data.banner.data}`;
                    document.getElementById("descripcionArtista").textContent = data.descripcion;
                    document.getElementById("seguidores").textContent = data.seguidores;
                    document.getElementById("oyentes").textContent = data.oyentes;
                    document.getElementById("lanzamientos").textContent = data.lanzamientos;
                    followButton.textContent = data.isFollowing ? "Dejar de seguir" : "Seguir";
                })
                .catch(console.error);

            // Mostrar canciones
            window.mostrarCanciones = function() {
                fetch(`../php5/obtener_canciones_artista_view.php?id_artista=${idArtista}`)
                    .then(response => response.json())
                    .then(canciones => {
                        const contenedor = document.getElementById("contenedor-canciones-albums");
                        contenedor.innerHTML = "";
                        canciones.forEach(cancion => {
                            const cancionDiv = document.createElement("div");
                            cancionDiv.classList.add("cancion-item");
                            cancionDiv.innerHTML = `
                                <img src="data:${cancion.tipo_foto};base64,${cancion.foto}" alt="Foto canción">
                                <p>${cancion.titulo}</p>`;
                            cancionDiv.addEventListener("click", () => reproducirCancion(cancion));
                            contenedor.appendChild(cancionDiv);
                        });
                    })
                    .catch(console.error);
            };

            async function incrementarReproduccion(id_musica) {
                const id_oyente = new URLSearchParams(window.location.search).get('id');
                try {
                    await fetch(`../php5/incrementar_reproduccion.php?id_musica=${id_musica}&id_oyente=${id_oyente}`, {
                        method: 'POST'
                    });
                } catch (error) {
                    console.error('Error al incrementar la reproducción:', error);
                }
            }


            // Mostrar álbumes
            window.mostrarAlbums = function() {
                fetch(`../php5/obtener_albums_artista_view.php?id_artista=${idArtista}`)
                    .then(response => response.json())
                    .then(albums => {
                        const contenedor = document.getElementById("contenedor-canciones-albums");
                        contenedor.innerHTML = albums.length === 0 ?
                            `<p>El artista todavi ano tiene Albums</p>` :
                            albums.map(album => `
                                <div class="album-item" onclick="irAPagina2('album_completo.php?id=${idOyente}&id_album=${album.id_album}')">
                                    <img src="data:${album.tipo_foto};base64,${album.foto}" alt="Foto álbum">
                                    <p>${album.nombre}</p>
                                </div>`).join('');
                    })
                    .catch(console.error);
            };

            function reproducirCancion(cancion) {
                audio.src = `data:${cancion.tipo_audio};base64,${cancion.archivo}`;
                audio.play();

                // Actualiza la información del reproductor con los datos de la canción
                document.getElementById("tituloReproduccion").textContent = cancion.titulo;
                document.querySelector(".artista-cancion").textContent = cancion.artista;
                document.querySelector(".portada").src = `data:${cancion.tipo_foto};base64,${cancion.foto}`;

                document.getElementById("play-icon").style.display = "none";
                document.getElementById("pause-icon").style.display = "inline";
                isPlaying = true;

                // Incrementar la reproducción de la canción
                incrementarReproduccion(cancion.id_musica);
            }

            audio.addEventListener("loadedmetadata", () => {
                duracion.textContent = formatTime(audio.duration);
                barraProgreso.max = Math.floor(audio.duration);
            });

            // Actualizar la barra de progreso y el tiempo actual de la canción mientras se reproduce
            audio.addEventListener("timeupdate", () => {
                barraProgreso.value = Math.floor(audio.currentTime);
                tiempoActual.textContent = formatTime(audio.currentTime);
            });

            barraProgreso.addEventListener("input", () => {
                audio.currentTime = barraProgreso.value;
            });


            // Control de reproducción
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

            // Seguir/Dejar de seguir artista
            window.toggleFollow = function() {
                fetch(`../php5/toggle_follow.php?id_oyente=${idOyente}&id_artista=${idArtista}`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("seguidores").textContent = data.nuevos_seguidores;
                        followButton.textContent = data.isFollowing ? "Dejar de seguir" : "Seguir";
                    })
                    .catch(console.error);
            };
        });
    </script>

</body>

</html>