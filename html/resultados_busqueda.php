<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_shop.css">
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
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('principal.php')">Musica</a>
                <a class="sin-mod" href="shop.php?id=<?php echo $_GET['id']; ?>">Tienda</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <h2 class="titulo">Resultados de Búsqueda</h2>
            <div id="resultados-artistas">
                <h3>Artistas Encontrados</h3>
                <div class="seccion-artistas"></div>
            </div>
            <div id="resultados-productos">
                <h3>Productos Encontrados</h3>
                <div class="seccion-merch"></div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script>
        const terminoBusqueda = "<?php echo isset($_GET['busqueda']) ? $_GET['busqueda'] : ''; ?>";
        const idOyente = "<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>";

        if (terminoBusqueda) {
            fetch(`../php2/buscar_productos.php?busqueda=${encodeURIComponent(terminoBusqueda)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.artistas.length > 0) {
                            mostrarArtistas(data.artistas);
                        } else {
                            document.getElementById('resultados-artistas').innerHTML += "<p>No se encontraron artistas.</p>";
                        }
                        if (data.productos.length > 0) {
                            mostrarProductos(data.productos);
                        } else {
                            document.getElementById('resultados-productos').innerHTML += "<p>No se encontraron productos.</p>";
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function mostrarArtistas(artistas) {
            const artistasContainer = document.querySelector('#resultados-artistas .seccion-artistas');
            artistasContainer.innerHTML = '';

            artistas.forEach(artista => {
                const artistaHTML = `
                <a href="productos_artista.php?id_artista=${artista.idartista}&id=${idOyente}" class="link-artista">
                    <div class="artista">
                        <img class="img-artista" src="${artista.foto}" alt="${artista.nombre_artistico}">
                        <p class="nombre-artista">${artista.nombre_artistico}</p>
                    </div>
                </a>
            `;
                artistasContainer.innerHTML += artistaHTML;
            });
        }

        function mostrarProductos(productos) {
            const productosContainer = document.querySelector('#resultados-productos .seccion-merch');
            productosContainer.innerHTML = '';

            productos.forEach(producto => {
                const productoHTML = `
                <a href="producto.php?id_producto=${producto.id_producto}&id=${idOyente}" class="link-producto">
                    <div class="merch">
                        <img class="img-merch" src="${producto.imagen_producto}" alt="${producto.nombre_producto}">
                        <p class="contenido-merch nombre-artista-merch">${producto.nombre_artistico || "Artista Desconocido"}</p>
                        <p class="contenido-merch nombre-merch">${producto.nombre_producto}</p>
                        <p class="contenido-merch precio">$${producto.precio}</p>
                    </div>
                </a>
            `;
                productosContainer.innerHTML += productoHTML;
            });
        }
    </script>
</body>

</html>