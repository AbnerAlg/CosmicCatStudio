<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Todos los Álbumes</title>
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
            <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('principal.php')">Musica</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <h2 class="encabezado-canciones">Todos los Álbumes</h2>
            <div class="lista-canciones grid-canciones" id="contenedor-todos-albums">
                <!-- Álbumes se cargarán dinámicamente aquí -->
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const idOyente = new URLSearchParams(window.location.search).get('id');
            const contenedorAlbums = document.getElementById("contenedor-todos-albums");

            // Cargar todos los álbumes
            fetch('../php5/obtener_albums_completo.php')
                .then(response => response.json())
                .then(albums => {
                    contenedorAlbums.innerHTML = albums.map(album => `
                        <div class="cancion" onclick="irAPagina('album_completo.php?id=${idOyente}&id_album=${album.id_album}')">
                            <img class="musica-imagen" src="data:${album.tipo_foto};base64,${album.foto}" alt="${album.nombre}">
                            <p class="musica-titulo letra">${album.nombre}</p>
                            <p class="musica-autor letra">${album.nombre_artistico}</p>
                        </div>
                    `).join('');
                })
                .catch(error => {
                    console.error("Error al cargar los álbumes:", error);
                    contenedorAlbums.innerHTML = "<p>Error al cargar los álbumes.</p>";
                });
        });
    </script>
</body>

</html>
