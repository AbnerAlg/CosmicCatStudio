<?php
require '../php5/inicio_perfil_listener.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Oyente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">

    <script>
        const idoyente = new URLSearchParams(window.location.search).get('id');

        function irAPagina(url) {
            window.location.href = url + `?id=${idoyente}`;
        }

        function irAPagina2(url) {
            window.location.href = url;
        }
        // Almacenar los datos de oyente en una variable global en JSON

        const oyenteData = <?php echo $json_data; ?>;

        document.addEventListener('DOMContentLoaded', () => {
            // Asignar el banner
            const bannerImg = document.querySelector('.banner');
            bannerImg.src = `data:${oyenteData.banner.type};base64,${oyenteData.banner.data}`;

            // Asignar el avatar
            const avatarImg = document.querySelector('.foto-perfil');
            avatarImg.src = `data:${oyenteData.avatar.type};base64,${oyenteData.avatar.data}`;

            // Asignar el nombre
            document.querySelector('.nombre').textContent = oyenteData.nombre;

            // Asignar las estadísticas (siguiendo y comunidades)
            document.querySelector('#siguiendo').textContent = oyenteData.siguiendo;
            document.querySelector('#comunidades').textContent = oyenteData.comunidades;

            const id_oyente = new URLSearchParams(window.location.search).get('id');

            // Obtener los artistas seguidos por el oyente
            fetch(`../php5/obtener_seguidos.php?id_oyente=${id_oyente}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarArtistasSeguidos(data.artistas);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los artistas seguidos:', error);
                });
        });


        function mostrarArtistasSeguidos(artistas) {
            const contenedorAlbum = document.querySelector('.contenedor-album');
            contenedorAlbum.innerHTML = ''; // Limpiar el contenedor

            artistas.forEach(artista => {
                const artistaHTML = `
            <div class="contenedor-imagen">
                <a href="#" onclick="event.preventDefault(); redirigirAlPerfil(${artista.idartista})">
                    <img class="imagen" src="data:${artista.tipo_avatar};base64,${artista.avatar}" alt="Imagen del artista">
                </a>
            </div>
        `;
                contenedorAlbum.innerHTML += artistaHTML;
            });
        }

        function redirigirAlPerfil(id_artista) {
            const id_oyente = new URLSearchParams(window.location.search).get('id');

            // Realizar el fetch para incrementar la visita
            fetch(`../php5/sumar_visita.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id_oyente,
                        id_artista
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redireccionar al perfil del artista con los parámetros en la URL
                        window.location.href = `../html/profile_view.php?id=${id_oyente}&idart=${id_artista}`;
                    } else {
                        console.error('Error al sumar la visita:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error al sumar la visita:', error);
                });
        }
    </script>
</head>

<body>
    <header>
        <div class="contenedor-header">
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt=""></a></h1>
            <nav class="navegacion">
                <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('principal.php')">Musica</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a onclick="irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-perfil">
            <div class="contenedor-banner">
                <img class="banner" src="../img/BANNER_LISTENER2.jpg" alt="Banner">
            </div>


            <div class="contenedor-foto-perfil">
                <div class="boton-izquierdo ocultar">
                    <button onclick="irAPagina('editProfileOyente.php')" class="boton-accion"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                            <path d="M16 5l3 3" />
                        </svg>
                        <p>Editar perfil</p>
                    </button>
                </div>
                <img class="foto-perfil" src="../img/LISTENER2.jpg" alt="Foto de perfil">


                <div class="boton-derecho">
                    <button onclick="irAPagina('editProfileOyente.php')" class="boton-accion"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                            <path d="M16 5l3 3" />
                        </svg>
                        <p>Editar perfil</p>
                    </button>
                </div>
            </div>

            <h2 class="nombre">Andy</h2>

            <div class="contenedor-estadisticas-oyente">
                <div class="estadistica">
                    <p class="estadistica-dato" id="siguiendo"><strong>0</strong></p>
                    <p>Siguiendo</p>
                </div>
                <div class="estadistica">
                    <p class="estadistica-dato" id="comunidades"><strong>0</strong></p>
                    <p>Comunidades</p>
                </div>
            </div>

            <h2 class="titulo">Tus artistas</h2>

            <div class="contenedor-album">
                <div class="contenedor-imagen"><a href="#"><img class="imagen" src="../img/Bratty_perfil.jpg"
                            alt="Imagen del artista"></a></div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>
</body>

</html>