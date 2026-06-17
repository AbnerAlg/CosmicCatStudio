<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegir comunidades</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_shop.css">
    <link rel="stylesheet" href="../css/elegir-comunidad.css">

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
                        alt=""></a>
            </h1>
            <nav class="navegacion">
            <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('principal.php')">Musica</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php');">Tienda</a>
                <a class="sin-mod" onclick="irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <h2 class="titulo">Comunidades disponibles</h2>
            <div class="arriba-tienda">

            </div>

            <div class="contenedor-merch">
                <div class="seccion-merch">
                    <a href="" class="link-producto">
                        <div class="merch">
                            <img class="img-merch" src="../img/merch2.webp" alt="merch">
                            <p class="contenido-merch nombre-artista-merch">Bratty</p>
                            <p class="contenido-merch nombre-merch">Culichis</p>

                            <button class="boton-compra" onclick="event.preventDefault();">Ingresar</button>
                        </div>
                    </a>
                    <a href="" class="link-producto">
                        <div class="merch">
                            <img class="img-merch" src="../img/merch1.webp" alt="merch">
                            <p class="contenido-merch nombre-artista-merch">Billie</p>
                            <p class="contenido-merch nombre-merch">Avocados</p>

                            <button class="boton-compra" onclick="event.preventDefault();">Ingresar</button>
                        </div>
                    </a>
                    <a href="" class="link-producto">
                        <div class="merch">
                            <img class="img-merch" src="../img/merch3.webp" alt="merch">
                            <p class="contenido-merch nombre-artista-merch">Harry Styles</p>
                            <p class="contenido-merch nombre-merch">Stylers</p>

                            <button class="boton-compra" onclick="event.preventDefault();">Ingresar</button>
                        </div>
                    </a>
                    <a href="" class="link-producto">
                        <div class="merch">
                            <img class="img-merch" src="../img/merch4.webp" alt="merch">
                            <p class="contenido-merch nombre-artista-merch">Sabrina Carpenter</p>
                            <p class="contenido-merch nombre-merch">Carpenters</p>

                            <button class="boton-compra" onclick="event.preventDefault();">Ingresar</button>
                        </div>
                    </a>



                </div>
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
            const id_oyente = new URLSearchParams(window.location.search).get('id');

            // Cargar comunidades disponibles
            fetch(`../php5/mostrar-comunidad-listener.php?id=${id_oyente}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarComunidades(data.comunidades, id_oyente);  // Pasamos id_oyente
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error al cargar comunidades:', error));
        });

        // Mostrar comunidades en el HTML, ahora aceptando `id_oyente` como parámetro
        function mostrarComunidades(comunidades, id_oyente) {
            const contenedorMerch = document.querySelector('.seccion-merch');
            contenedorMerch.innerHTML = ""; // Limpiar contenido previo

            comunidades.forEach(comunidad => {
                const comunidadHTML = `
            <div class="merch">
                <img class="img-merch" src="data:${comunidad.tipo_foto};base64,${comunidad.foto}" alt="Foto de ${comunidad.nombre}">
                <p class="contenido-merch nombre-artista-merch">${comunidad.artista_nombre}</p>
                <p class="contenido-merch nombre-merch">${comunidad.nombre}</p>
                <button class="boton-compra" onclick="ingresarComunidad(${comunidad.id_comunidad}, ${id_oyente})">Ingresar</button>
            </div>
        `;
                contenedorMerch.insertAdjacentHTML("beforeend", comunidadHTML);
            });
        }

        // Función para unirse a una comunidad
        function ingresarComunidad(id_comunidad, id_oyente) {
            fetch(`../php5/ingresar-comunidad.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_comunidad, id_oyente })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Te has unido a la comunidad correctamente.");
                        location.reload(); // Recargar para actualizar la lista de comunidades
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error al unirse a la comunidad:', error));
        }

    </script>


</body>

</html>