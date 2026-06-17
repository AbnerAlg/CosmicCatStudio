<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_estadisticas.css">

</head>

<body>
    <script>
        const idArtista = new URLSearchParams(window.location.search).get('id');
        function irAPagina(url) {
            window.location.href = url + `?id=${idArtista}`;
        }
        function irAPagina2(url) {
            window.location.href = url;
        }
    </script>


    <header>
        <div class="contenedor-header">
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt=""></a>
            </h1>
            <nav class="navegacion">
                <a class="sin-mod" href="#">Musica</a>
                <a class="sin-mod" href="#" onclick="event.preventDefault();irAPagina('misProductos.php')">Mis
                    productos</a>
                <a class="sin-mod" href="#" onclick="event.preventDefault();irAPagina('comunidad-view-artist.php')">Mi
                    Comunidad</a>
                <a class="sin-mod" href="#" onclick="event.preventDefault();irAPagina('profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">

            <div class="cabecera-estadisticas">
                <h2>Tus estadísticas</h2>
            </div>

            <div class="contenedor-estadisticas">
                <div class="contenedor-visitas">
                    <h3>Visitas al perfil</h3>
                    <canvas id="graficoLineal"></canvas>
                </div>

                <div class="contenedor-canciones">
                    <h3>Canciones más escuchadas</h3>
                    <canvas id="graficoCanciones"></canvas>
                </div>
            </div>





        </div>




    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/graficos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/grafico_canciones.js"></script>

</body>

</html>