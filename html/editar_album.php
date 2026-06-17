<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Album</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_crearalbum.css">
    <link rel="stylesheet" href="../css/editar_album.css">
</head>

<body>
<script>
        
        function irAPagina2(url) {
            window.location.href = url;
        }
    </script>
    <header>
        <div class="contenedor-header">
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt=""></a></h1>
            <nav class="navegacion">
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('misProductos.php');">Mis
                    productos</a>
                <a class="sin-mod" onclick="irAPagina('profile.php')">Perfil</a>
                <a class="sin-mod" onclick="irAPagina('comunidad-view-artist.php')">Mi comunidad</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-editar-album">
            <h2>Editar Álbum</h2>
            <form id="editar-album-form">
                <label for="nombre-album">Nombre del Álbum</label>
                <input type="text" id="nombre-album" name="nombre_album" required>

                <label for="descripcion-album">Descripción</label>
                <textarea id="descripcion-album" name="descripcion_album" rows="3" required></textarea>

                <label for="foto-album">Foto del Álbum</label>
                <input type="file" id="foto-album" name="foto_album">
                <img id="vista-previa" src="" alt="Vista Previa de Foto del Álbum" style="display: none; width: 150px;">

                <button type="button" onclick="guardarCambiosAlbum()">Guardar Cambios</button>
            </form>

            <div class="listas-canciones">
                <div class="canciones-album">
                    <h3>Canciones en el Álbum</h3>
                    <div id="lista-canciones-album"></div>
                </div>
                
                <div class="canciones-no-album">
                    <h3>Canciones sin Álbum</h3>
                    <div id="lista-canciones-no-album"></div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script src="../js/editar_album.js"></script>
</body>
</html>
