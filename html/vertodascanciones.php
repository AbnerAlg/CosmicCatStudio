<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Todas las Canciones</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/principal.css">
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
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png" alt=""></a></h1>
            <nav class="navegacion">
            <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <h2 class="encabezado-canciones">Todas las Canciones</h2>
            <div class="lista-canciones grid-canciones" id="contenedor-todas-canciones">
                <!-- Canciones se cargarán dinámicamente aquí -->
            </div>
        </div>
    </main>

    <div class="reproductor-musica">
        <div class="info-cancion">
            <img src="../img/MUSICA1.jpg" alt="Portada del álbum" class="portada">
            <div class="detalles-cancion">
                <p class="titulo-cancion">Expresso</p>
                <p class="artista-cancion">Sabrina Carpenter</p>
            </div>
        </div>
        <div class="medio-reproductor">
            <input type="range" id="barra-progreso" value="0" max="100" class="barra-progreso">
            <div class="tiempo">
                <span id="tiempo-actual">0:00</span> / <span id="duracion">0:00</span>
            </div>
            <div class="controles-reproductor">
                <button class="boton-control" id="skip-backward">...</button>
                <button class="boton-control" id="play-pause">...</button>
                <button class="boton-control" id="skip-forward">...</button>
            </div>
        </div>
        <audio id="audio"></audio>
        <script src="../js/verTodasCanciones.js"></script>
    </div>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>
</body>

</html>
