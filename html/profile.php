<?php
require '../php5/inicio_perfil_artista.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Artista</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">

    <script>
        // Aquí se almacenará el JSON de PHP
        const artistaData = <?php echo $json_data; ?>;

        function irAPagina(url) {
            window.location.href = url + `?id=${artistaData.id_artista}`;
        }

        function irAPagina2(url) {
            window.location.href = url;
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Asignar el banner
            const bannerImg = document.querySelector('.banner');
            bannerImg.src = `data:${artistaData.banner.type};base64,${artistaData.banner.data}`;

            // Asignar el avatar
            const avatarImg = document.querySelector('.foto-perfil');
            avatarImg.src = `data:${artistaData.avatar.type};base64,${artistaData.avatar.data}`;

            document.getElementById('nombre').innerHTML = `<strong>${artistaData.nombre_artistico}</strong>`;
            document.getElementById('descripcion').innerHTML = `${artistaData.descripcion}`;
            // Asignar las estadísticas
            document.getElementById('seguidores').innerHTML = `<strong>${artistaData.seguidores}</strong>`;

            document.getElementById('oyentes').innerHTML = `<strong>${artistaData.oyentes}</strong>`;
            document.getElementById('lanzamientos').innerHTML = `<strong>${artistaData.lanzamientos}</strong>`;
        });
    </script>

</head>

<body>
    <header>
        <div class="contenedor-header">
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt=""></a>
            </h1>
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

        <div class="contenedor-perfil">
            <div class="contenedor-banner">
                <img class="banner" src="../img/Bratty.jpg" alt="Banner">
            </div>
            <div class="contenedor-foto-perfil">
                <div class="boton-izquierdo">
                    <button onclick="irAPagina('estadisticas.php')" class="boton-accion"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-chart-line">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 19l16 0" />
                            <path d="M4 15l4 -6l4 2l4 -5l4 4" />
                        </svg>
                        <p>Ver estadisticas</p>
                    </button>
                </div>


                <img class="foto-perfil" src="../img/Bratty_perfil.jpg" alt="Foto de Perfil">

                <div class="boton-derecho">
                    <button onclick="irAPagina('editProfileArtist.php')" class="boton-accion"><svg
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
            <h2 id="nombre" class="nombre">Bratty</h2>

            <p id="descripcion" class="descripcion-artista">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Omnis, eos. Aliquam
                rerum ad quia eius modi,
                maiores nostrum, at voluptatem, quae repellat nisi ipsum atque dolores voluptate? Autem, voluptas. Sint.
            </p>

            <div class="contenedor-estadisticas">
                <div class="estadistica">
                    <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('mostrar_seguidores.php')">
                        <p class="estadistica-dato" id="seguidores"><strong>500</strong></p>
                    </a>
                    <p>Seguidores</p>
                </div>
                <div class="estadistica">
                    <p class="estadistica-dato" id="oyentes"><strong>5.7K</strong></p>
                    <p>Oyentes</p>
                </div>
                <div class="estadistica">
                    <p class="estadistica-dato" id="lanzamientos"><strong>5</strong></p>
                    <p>Lanzamientos</p>
                </div>
            </div>
            <div class="encabezado_titulos">
            <h2 class="titulo" id="titulo-canciones" onclick="mostrarCanciones()">Canciones</h2>
            <h2 class="titulo" id="titulo-albums" onclick="mostrarAlbums()">Álbums</h2>
            </div>
            
            <button onclick="irAPagina('musica.php')" id="subir-musica-btn"
                style="display:block;margin-left:3rem; margin-bottom: 3rem" class="boton-accion">Subir
                Música</button>
            <button onclick="irAPagina('crearAlbum.php')" id="crear-album-btn"
                style="display:none;margin-left:3rem; margin-bottom: 3rem; justify-content:center" class="boton-accion">Crear Álbum</button>
            <div class="contenedor-album" id="contenedor-canciones-albums">
                <!-- Aquí se cargarán las canciones o los álbums dinámicamente -->
            </div>



        </div>




    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>

    </footer>
    <div id="overlay-eliminar" style="display:none">
        <div class="overlay-content">
            <p>¿Estás seguro de que deseas eliminar esta canción?</p>
            <button id="confirmar-eliminar">Sí</button>
            <button id="cancelar-eliminar">No</button>
        </div>
    </div>

    <script src="../js/perfil_js.js"></script>


</body>


</html>