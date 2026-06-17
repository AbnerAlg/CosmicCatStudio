<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Todos los Artistas</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/principal.css"> <!-- Reutilizamos el estilo -->
</head>

<body>
    <script>
        const idOyente = new URLSearchParams(window.location.search).get('id');
        function irAPagina(url) {
            window.location.href = url + `?id=${idOyente}`;
        }
        function irAPagina2(url) {
            window.location.href = url;
        }
    </script>

    <!-- Header -->
    <header>
        <div class="contenedor-header">
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt="Logo"></a></h1>
            <nav class="navegacion">
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main>
        <div class="contenedor-main">
            <div class="musica-artistas padding-contenedores">
                <div class="contenedor-cabecera">
                    <h2 class="encabezado-canciones">Todos los Artistas</h2>
                </div>
                <div class="lista-canciones" id="contenedor-artistas">
                    <!-- Aquí se insertarán los artistas dinámicamente -->
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script src="../js/ver_todo_artistas.js"></script> <!-- Archivo JS para cargar los artistas -->
</body>

</html>