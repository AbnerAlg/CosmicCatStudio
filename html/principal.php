<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
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
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt=""></a>
            </h1>
            <nav class="navegacion">
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <div class="contenedor-musica">
                <div class="navegacion-musica">
                    <nav>
                        <a class="sin-mod opcion-musica activo" href="#">Inicio</a>
                    </nav>
                </div>

                <div class="musica-canciones padding-contenedores">
                    <div class="contenedor-cabecera">
                        <h2 class="encabezado-canciones">Escuchado recientemente</h2>
                        <a href="" onclick="event.preventDefault(); irAPagina('ver_todo_historial.php')"
                            class="sin-mod opcion-todo">Ver todo</a>
                    </div>
                    <div class="lista-canciones">
                        <a id="btnEspresso" href="#" class="sin-mod"
                            onclick="event.preventDefault(); reproducirCancion('canciones/espresso.mp3', 'Espresso', 'Sabrina Carpenter', '../img/MUSICA1.jpg')">
                            <div class="cancion">
                                <img class="musica-imagen" src="../img/MUSICA1.jpg" alt="musica">
                                <p class="musica-titulo letra">Espresso</p>
                                <p class="musica-autor letra">Sabrina Carpenter</p>
                            </div>
                        </a>


                        <a href="" class="sin-mod">
                            <div class="cancion">
                                <img class="musica-imagen" src="../img/MUSICA2.jpg" alt="musica">
                                <p class="musica-titulo letra">emails i can't send</p>
                                <p class="musica-autor letra">Sabrina Carpenter</p>
                            </div>
                        </a>

                        <a href="" class="sin-mod">
                            <div class="cancion">
                                <img class="musica-imagen" src="../img/MUSICA4.jpg" alt="musica">
                                <p class="musica-titulo letra">Birds of a Feather</p>
                                <p class="musica-autor letra">Billie Eillish</p>
                            </div>
                        </a>

                        <a href="" class="sin-mod">
                            <div class="cancion">
                                <img class="musica-imagen" src="../img/MUSICA5.jpg" alt="musica">
                                <p class="musica-titulo letra">Halley's Comet</p>
                                <p class="musica-autor letra">Billie Eillish</p>
                            </div>
                        </a>

                        <a href="" class="sin-mod">
                            <div class="cancion">
                                <img class="musica-imagen" src="../img/MUSICA6.jpg" alt="musica">
                                <p class="musica-titulo letra">Love Yourself</p>
                                <p class="musica-autor letra">Justin Bieber</p>
                            </div>
                        </a>

                        <a href="" class="sin-mod">
                            <div class="cancion">
                                <img class="musica-imagen" src="../img/MUSICA7.jpg" alt="musica">
                                <p class="musica-titulo letra">Todo de ti</p>
                                <p class="musica-autor letra">Rauw Alejandro</p>
                            </div>
                        </a>


                    </div>



                </div>

                <div class="musica-recomendaciones padding-contenedores">
                    <div class="contenedor-cabecera">
                        <h2 class="encabezado-canciones">Recomendaciones</h2>
                        <a href="" onclick="event.preventDefault(); irAPagina('vertodascanciones.php')"
                            class="sin-mod opcion-todo">Ver todo</a>
                    </div>
                    <div class="lista-canciones" id="contenedor-recomendaciones">
                        <!-- Aquí se insertarán las canciones recomendadas dinámicamente -->
                    </div>
                </div>

                <div class="musica-albums padding-contenedores">
                    <div class="contenedor-cabecera">
                        <h2 class="encabezado-canciones">Álbums</h2>
                        <a href="#" onclick="event.preventDefault(); irAPagina('ver_todo_albums.php')"
                            class="sin-mod opcion-todo">Ver todo</a>
                    </div>
                    <div class="lista-canciones" id="contenedor-albums">
                        <!-- Aquí se cargarán los álbums -->
                    </div>
                </div>



                <div class="musica-artistas">
                    <div class="contenedor-cabecera">
                        <h2 class="encabezado-canciones">Artistas</h2>
                        <a href="#" onclick="event.preventDefault(); irAPagina('ver_todo_artistas.php')"
                            class="sin-mod opcion-todo">Ver todo</a>
                    </div>
                    <div class="lista-canciones" id="contenedor-artistas">
                        <!-- Aquí se cargarán los artistas dinámicamente -->
                    </div>
                </div>
            </div>

        </div>


    </main>

    <div class="reproductor-musica">
        <div class="info-cancion">
            <img src="../img/MUSICA1.jpg" alt="Portada del álbum" class="portada">
            <div class="detalles-cancion">
                <p class="titulo-cancion">Expresso</p>
                <p class="artista-cancion">Sabrina Carpenter</p>
            </div>
        </div>
        <div class="medio-reproductor">
            <input type="range" id="barra-progreso" value="0" max="100" class="barra-progreso">
            <div class="tiempo">
                <span id="tiempo-actual">0:00</span> / <span id="duracion">0:00</span>
            </div>
            <div class="controles-reproductor">
                <button class="boton-control" id="skip-backward">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M19.496 4.136l-12 7a1 1 0 0 0 0 1.728l12 7a1 1 0 0 0 1.504 -.864v-14a1 1 0 0 0 -1.504 -.864z" />
                        <path
                            d="M4 4a1 1 0 0 1 .993 .883l.007 .117v14a1 1 0 0 1 -1.993 .117l-.007 -.117v-14a1 1 0 0 1 1 -1z" />
                    </svg>
                </button>
                <button class="boton-control" id="play-pause">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" />
                        <path d="M17 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" />
                    </svg>
                </button>
                <button class="boton-control" id="skip-forward">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 5v14a1 1 0 0 0 1.504 .864l12 -7a1 1 0 0 0 0 -1.728l-12 -7a1 1 0 0 0 -1.504 .864z" />
                        <path
                            d="M20 4a1 1 0 0 1 .993 .883l.007 .117v14a1 1 0 0 1 -1.993 .117l-.007 -.117v-14a1 1 0 0 1 1 -1z" />
                    </svg>
                </button>
            </div>
        </div>
        <audio id="audio"></audio>

        <script>


        </script>
        <script src="../js/Scripts.js"></script>
    </div>




    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>

    </footer>





</body>

</html>