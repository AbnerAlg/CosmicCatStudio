<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_comunidad.css">
</head>

<body>
    <script>
        const idArt = new URLSearchParams(window.location.search).get('id');

        function irAPagina(url) {
            window.location.href = url + `?id=${idArt}`;
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
                <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('principal.php');">Musica</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php');">Tienda</a>
                <a class="sin-mod" onclick="irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>

        <div class="contenedor-main">

            <div class="comu">
                <h2>Tus comunidades</h2>
                <a href="" onclick="event.preventDefault(); verComunidades()" class="sin-mod btn-link">Ver más comunidades</a>
                <div class="lista-comunidades">


                </div>

            </div>


            <div class="contenedor-comunidad">
                <h2 id="titulo-comunidad"></h2>
                <button id="boton-salir-comunidad" onclick="salirDeComunidad()" style="display: none;">Salir de la Comunidad</button>
                <div id="publicaciones-container" class="publicacion">
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <div id="overlay" class="overlay" onclick="cerrarModal(event)"></div>
    <div id="recuadro-comentarios" class="recuadro-comentarios">
        <div class="lista-comentarios-contenedor"></div>
        <button onclick="ocultarRecuadro()">Cerrar</button>
    </div>

    <script src="../js/comunidad.js"></script>
</body>

</html>