<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_carrito.css">
</head>

<body>
    <script>
        function irAPagina(url) {
            const idoye = new URLSearchParams(window.location.search).get('id');
            window.location.href = url + `?id=${idoye}`;
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
                <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href="#"
                    onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <div class="cabecera-carrito">
                <h2>Tu Carrito</h2>
            </div>

            <div id="carrito-container" class="contenedor-productos-pago">
                <!-- Productos del carrito se cargarán aquí dinámicamente -->
            </div>

            <div id="mensaje-carrito-vacio" class="carrito-vacio" style="display: none;">
                <img src="../img/cart.png" alt="Carrito vacío" class="icono-carrito-vacio">
                <h3>Upssss! no tienes elementos en tu carrito</h3>
                <p>Agrega productos a tu carrito.</p>
                <a href="#" id="boton-tienda" class="boton-tienda">Ir a tienda</a>
            </div>

            <div class="contenedor-pago">
                <div class="informacion-pago" id="total-info">
                    <p><strong>Subtotal:</strong> $<span id="subtotal">0.00</span></p>
                    <p><strong>Envio:</strong> $<span id="envio">90.00</span></p>
                    <p><strong>Total:</strong> $<span id="total">90.00</span></p>
                    <button onclick="irAPagina2('formulario.php')" class="boton-pago">Pagar</button>
                </div>
            </div>


        </div>
    </main>
    <div id="overlay-mensaje" class="overlay" style="display: none;">
        <div class="mensaje-overlay">
            <p>Necesitas agregar productos al carrito antes de proceder al pago.</p>
            <button onclick="cerrarOverlay()">Entendido</button>
        </div>
    </div>
    <!-- Formulario oculto para enviar el total -->
    <!-- Formulario oculto para enviar solo el total -->
    <!-- Formulario oculto para enviar el total, cantidades y IDs de productos -->
    <form id="form-pago" action="formulario.php" method="POST" style="display: none;">
        <input type="hidden" name="total" id="totalInput">
        <div id="productos-inputs"></div> <!-- Contenedor para campos dinámicos -->
    </form>





    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const idOyente = urlParams.get('id');

        if (!idOyente) {
            alert('ID del oyente no especificado');
        } else {
            // Configura el enlace del botón "Ir a tienda" con el id del oyente
            document.getElementById('boton-tienda').href = `shop.php?id=${idOyente}`;

            fetch(`../php2/obtener_carrito.php?id=${idOyente}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && Array.isArray(data.carrito)) {
                        mostrarCarrito(data.carrito);
                        calcularTotal(data.carrito);
                    } else {
                        document.getElementById('carrito-container').style.display = "none";
                        document.getElementById('mensaje-carrito-vacio').style.display = "flex";
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Función para mostrar productos en el carrito
        function mostrarCarrito(carrito) {
            const carritoContainer = document.getElementById('carrito-container');
            carritoContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar productos

            carrito.forEach(item => {
                const itemHTML = `
                <div class="carrito-producto">
                    <div class="carrito-artista">
                        <h3>${item.nombre_artistico}</h3>
                        <div class="informacion-producto">
                            <div class="contenedor-img">
                                <img class="carrito-img-producto" src="${item.imagen_producto}" alt="${item.nombre_producto}">
                            </div>
                            <div class="contenedor-informacion">
                                <p class="carrito-producto-nombre">${item.nombre_producto}</p>
                                <p class="carrito-producto-precio">$${parseFloat(item.precio).toFixed(2)}</p>
                                <div class="cantidad-eliminar">
                                    <input class="informacion-merch-cantidad" type="number" min="1" max="${item.stock}" step="1" value="${item.cantidad}">
                                    <a class="sin-mod carrito-producto-eliminar" href="#" onclick="eliminarProductoDelCarrito(${item.id_producto})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icon-tabler-trash-x">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" />
                                            <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                carritoContainer.innerHTML += itemHTML;
            });
        }

        // Función para eliminar producto del carrito
        function eliminarProductoDelCarrito(idProducto) {
            if (!confirm("¿Estás seguro de que deseas eliminar este producto del carrito?")) return;

            const formData = {
                id_oyente: idOyente,
                id_producto: idProducto
            };

            fetch('../php2/eliminar_del_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Recargar el carrito después de eliminar el producto
                        location.reload();
                    } else {
                        alert('Error al eliminar el producto del carrito: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Función para calcular el total
        function calcularTotal(carrito) {
            const subtotal = carrito.reduce((acc, item) => acc + (parseFloat(item.precio) * parseInt(item.cantidad)), 0);
            const envio = 90.00;
            const total = subtotal + envio;

            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('envio').textContent = envio.toFixed(2);
            document.getElementById('total').textContent = total.toFixed(2);
        }

        function irAPagina2(url) {
            const carritoContainer = document.getElementById('carrito-container');
            const productosInputs = document.getElementById('productos-inputs');

            // Limpia los campos previos para evitar duplicados
            productosInputs.innerHTML = '';

            // Verifica si el carrito tiene productos
            if (carritoContainer.children.length === 0) {
                document.getElementById('overlay-mensaje').style.display = 'flex';
            } else {
                const idoye = new URLSearchParams(window.location.search).get('id');
                const total = document.getElementById('total').textContent; // Obtiene el total mostrado

                // Asigna el total al campo oculto del formulario
                document.getElementById('totalInput').value = total;

                // Itera sobre los productos del carrito para obtener ID y cantidad
                const productos = carritoContainer.querySelectorAll('.carrito-producto');
                productos.forEach((producto, index) => {
                    const idProducto = producto.querySelector('.carrito-producto-eliminar').getAttribute('onclick').match(/\d+/)[0];
                    const cantidad = producto.querySelector('.informacion-merch-cantidad').value;

                    // Crea campos ocultos para el ID y la cantidad de cada producto
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = `productos[${index}][id]`;
                    inputId.value = idProducto;

                    const inputCantidad = document.createElement('input');
                    inputCantidad.type = 'hidden';
                    inputCantidad.name = `productos[${index}][cantidad]`;
                    inputCantidad.value = cantidad;

                    productosInputs.appendChild(inputId);
                    productosInputs.appendChild(inputCantidad);
                });

                // Modifica la acción del formulario para incluir el idOyente en la URL
                document.getElementById('form-pago').action = `${url}?id=${idoye}`;

                // Envía el formulario
                document.getElementById('form-pago').submit();
            }
        }



        function cerrarOverlay() {
            document.getElementById('overlay-mensaje').style.display = 'none';
        }

    </script>

</body>

</html>