<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
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
                <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png" alt=""></a></h1>
                <nav class="navegacion">
                    <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('principal.php')">Musica</a>
                    <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                    <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                    <a class="sin-mod" href="#"  onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                    <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
                </nav>
            </div>
        </header>

        <main>
            <div class="contenedor-main">
                <h2 class="titulo">TIENDA</h2>
                <div class="arriba-tienda">
                    <div class="contenedor-buscador">
                        <input type="text" id="barra-buscador" class="barra-buscador" placeholder="Buscar productos...">
                        <button class="boton-buscador" onclick="buscarProductos()">Buscar</button>
                    </div>

                    <div class="icono-carro" onclick="mostrarCarrito()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart"
                            width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 17h-11v-14h-2" />
                            <path d="M6 5l14 1l-1 7h-13" />
                        </svg>
                        <span id="contador-carrito" class="contador-carrito"></span>
                    </div>
                </div>

                <div id="resultados-busqueda" class="contenedor-resultados-busqueda"></div>

                <div class="contenedor-merch">
                    <h2 class="titulo-seccion">Algunos productos de tu artista</h2>
                    <div class="seccion-merch">
                        <!-- Productos generados dinámicamente -->
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="contenedor-footer">
                <p>&#169; CosmicCatStudio 2024</p>
            </div>
        </footer>
    </body>


    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const idOyente = urlParams.get('id');

        if (!idOyente) {
            alert('ID del oyente no especificado');
        } else {
            fetch('../php2/obtener_productos.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarProductos(data.productos);
                    } else {
                        alert('No se encontraron productos');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function irAPagina(url) {
            window.location.href = url + `?id=${idOyente}`;
        }

        function mostrarCarrito() {
            irAPagina('carrito.php'); 
        }

        function buscarProductos() {
            const terminoBusqueda = document.getElementById('barra-buscador').value.trim();

            if (!terminoBusqueda) {
                alert("Por favor ingresa un término de búsqueda.");
                return;
            }

            fetch(`../php2/buscar_productos.php?busqueda=${encodeURIComponent(terminoBusqueda)}&id=${idOyente}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.contenedor-merch').style.display = 'none';
                    if (data.success && data.productos.length > 0) {
                        mostrarResultadosBusqueda(data.productos);
                    } else {
                        document.getElementById('resultados-busqueda').innerHTML = "<p>No se encontraron productos.</p>";
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function mostrarProductos(productos) {
            const seccionMerch = document.querySelector('.seccion-merch');
            seccionMerch.innerHTML = '';

            productos.forEach(producto => {
                const productoHTML = `
                    <div class="merch" onclick="window.location.href='producto.html?id_producto=${producto.id_producto}&id_oyente=${idOyente}'">
                        <img class="img-merch" src="${producto.imagen_producto}" alt="${producto.nombre_producto}">
                        <p class="contenido-merch nombre-artista-merch">${producto.nombre_artista || "Artista Desconocido"}</p>
                        <p class="contenido-merch nombre-merch">${producto.nombre_producto}</p>
                        <p class="contenido-merch precio">$${producto.precio}</p>
                        <p class="contenido-merch stock">Stock: ${producto.stock}</p> <!-- Stock añadido aquí -->
                        <button class="boton-compra" onclick="event.stopPropagation(); agregarAlCarrito(${producto.id_producto})">Agregar al carrito</button>
                    </div>
                `;
                seccionMerch.innerHTML += productoHTML;
            });
        }

        function mostrarResultadosBusqueda(productos) {
            const resultadosContainer = document.getElementById('resultados-busqueda');
            resultadosContainer.innerHTML = '';

            let productosHTML = '<h3>Productos Encontrados</h3><div class="seccion-merch">';
            productos.forEach(producto => {
                productosHTML += `
                    <div class="merch" onclick="window.location.href='producto.html?id_producto=${producto.id_producto}&id_oyente=${idOyente}'">
                        <img class="img-merch" src="${producto.imagen_producto}" alt="${producto.nombre_producto}">
                        <p class="contenido-merch nombre-artista-merch">${producto.nombre_artistico || "Artista Desconocido"}</p>
                        <p class="contenido-merch nombre-merch">${producto.nombre_producto}</p>
                        <p class="contenido-merch precio">$${producto.precio}</p>
                        <button class="boton-compra" onclick="event.stopPropagation(); agregarAlCarrito(${producto.id_producto})">Agregar al carrito</button>
                    </div>
                `;
            });
            productosHTML += '</div>';
            resultadosContainer.innerHTML = productosHTML;
        }


        function agregarAlCarrito(idProducto) {
            const formData = {
                id_oyente: idOyente,
                id_producto: idProducto,
                cantidad: 1
            };

            fetch('../php2/agregar_al_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Producto agregado al carrito con éxito');
                } else {
                    alert('Error al agregar el producto al carrito: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function irAProducto(idProducto) {
            window.location.href = `producto.html?id_producto=${idProducto}&id=${idOyente}`;
        }
    </script>



</body>
</html>
