<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Álbum Completo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/reproductor_album.css">
</head>


<body>
    <script>
        // Aquí se almacenará el JSON de PHP
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
                <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="#"
                    onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('comunidad.php')">Mi
                    Comunidad</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <section class="contenedor-album">
            <h2 id="tituloAlbum" class="titulo-album">Título del Álbum</h2>
            <div class="portada-album">
                <img id="fotoAlbum" class="imagen-album" src="" alt="Portada del Álbum">
            </div>
            <div id="contenedor-canciones" class="contenedor-canciones">
                <!-- Las canciones se cargarán aquí -->
            </div>
        </section>
    </main>

    <!-- Reproductor de música fijado -->
    <div class="reproductor-musica">
        <div class="info-cancion">
            <img src="../img/MUSICA1.jpg" alt="Portada del álbum" class="portada" id="reproductorPortada">
            <div class="detalles-cancion">
                <p class="titulo-cancion" id="tituloReproduccion">Título Canción</p>
                <p class="artista-cancion" id="artistaReproduccion">Artista Canción</p>
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

    <script src="../js/scriptAlbum.js"></script>
</body>

</html>