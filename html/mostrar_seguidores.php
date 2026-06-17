<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguidores del Artista</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/mostrar_seguidores.css">
</head>
<body>
    <header>
        <div class="container-header">
            <h1 class="logo"><a class="sin-mod"><img class="logo-img" src="../img/LOGO-corregido.png" alt="CosmicCatStudio"></a></h1>
            <nav class="navegacion">
                <a class="sin-mod" href="#">Musica</a>
                <a class="sin-mod" onclick="irAPagina('misProductos.php')">Mis productos</a>
                <a class="sin-mod" onclick="irAPagina('profile.php')">Perfil</a>
                <a class="sin-mod" onclick="irAPagina('comunidad-view-artist.php')">Mi comunidad</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <h2>Seguidores</h2>
            <div id="seguidores-container" class="seguidores-container"></div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&copy; 2024 CosmicCatStudio. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        const idArtista = new URLSearchParams(window.location.search).get('id');
        function irAPagina(url) {
            window.location.href = url + `?id=${idArtista}`;
        }

        function irAPagina2(url) {
            window.location.href = url;
        }

        // Cargar seguidores del artista
        document.addEventListener("DOMContentLoaded", function() {
            fetch(`../php5/obtener_seguidores.php?id=${idArtista}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('seguidores-container');
                    container.innerHTML = data.seguidores.map(seguidor => `
                        <div class="seguidor-card">
                            <img src="data:${seguidor.avatar_tipo};base64,${seguidor.avatar}" class="seguidor-avatar" alt="Avatar de ${seguidor.nombre}">
                            <p class="seguidor-nombre">${seguidor.nombre}</p>
                        </div>
                    `).join('');
                })
                .catch(error => console.error('Error al cargar los seguidores:', error));
        });
    </script>
</body>
</html>
