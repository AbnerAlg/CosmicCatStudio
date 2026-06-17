
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webpage CosmicCatStudio</title>
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/loginStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>

    <div class="main">
        <div class="navbar">
            <div class="icon">
                <!-- <h2 class="logo">Logo</h2> -->
                <img src="../img/logoPagPrincipal.png" alt="Logo" class="logo">
            </div>

            <div class="menu">
                <ul>
                    <li><a href="#nosotros">NOSOTROS</a></li>
                    <li><a href="#cuentas">CUENTAS</a></li>
                    <li><a href="#servicios">SERVICIOS</a></li>
                    
                </ul>
            </div>

            <!-- <div class="search">
                <input class="srch" type="search" name="" placeholder="Escriba">
                <a href="#"> <button class="btn">Buscar</button></a>
            </div> -->

        </div> 
        <div class="content">
            <h1>CosmicCatStudio & <br><span>Development</span> <br>Bienvenido</h1>
            <p class="par">Empresa preocupada por los artistas independientes
            <br>De artistas
            <br> Para Artistas</p>

            <button class="cn"><a href="#nosotros">Conócenos</a></button>

            <div class="form">
                <h2>Inicio de sesión</h2>
                <input type="email" id="correo" name="email" placeholder="Ingrese su correo">

                <div class="form-control">
                    <input type="password" name="password" id="password" placeholder="Ingrese su contraseña">
                    <span class="toggle-password" onclick="togglePassword('password')">
                        <ion-icon name="eye-off"></ion-icon>
                    </span>
                </div>
                <button class="btnn" id="artista-boton"><a onclick="event.preventDefault()" href="#">Entrar</a></button>

                    <p class="link">¿No tienes cuenta?<br>
                    <a href="../html/createAcounts.php">Crea una cuenta</a> </p>
                    <!-- <p class="liw">Entrar con</p> -->

                    <div class="icons">
                        <a href="https://www.facebook.com/CosmicCatGamesOfficial?mibextid=ZbWKwL" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>
                        <a href="#"><ion-icon target="_blank" name="logo-instagram"></ion-icon></a>
                        <a href="#"><ion-icon target="_blank" name="logo-twitter"></ion-icon></a>
                        <!-- <a href="#"><ion-icon name="logo-google"></ion-icon></a>
                        <a href="#"><ion-icon name="logo-skype"></ion-icon></a> -->
                    </div>
                </div>        
            </div>
            <br>
            <br>
            <br>
              
            <!-- NOSOTROS -->
            <section id="nosotros">
                <div class="nosotros-container">
                    <h2 class="nosotros-title">Conoce CosmicCatStudio</h2>
                    <div class="text-section">
                        <p class="nosotros-description">
                            CosmicCatStudio es una plataforma dedicada a conectar y empoderar a artistas emergentes, brindándoles las herramientas y el espacio para dar a conocer su trabajo. Nuestro objetivo es crear una comunidad donde el arte y la creatividad sean el centro.
                        </p>
                        <div class="mision-vision">
                            <h3>Misión</h3>
                            <p>Nuestra misión es dar visibilidad a artistas emergentes a nivel global, ofreciéndoles una plataforma profesional para exhibir su talento y conectarse con otros creadores.</p>
                            
                            <h3>Visión</h3>
                            <p>Ser la plataforma de referencia para artistas emergentes en todo el mundo, donde la creatividad no tenga límites y la comunidad artística se fortalezca.</p>
                        </div>
                    </div>
            
                    <!--  Valores -->
                    <div class="valores-section">
                        <h3>Valores
                            <br>
                        <ul class="valores-list">
                            <li><ion-icon name="checkmark-circle"></ion-icon> Creatividad</li>
                            <li><ion-icon name="checkmark-circle"></ion-icon> Inclusión</li>
                            <li><ion-icon name="checkmark-circle"></ion-icon> Colaboración</li>
                            <li><ion-icon name="checkmark-circle"></ion-icon> Innovación</li>
                            <li><ion-icon name="checkmark-circle"></ion-icon> Confianza</li>
                        </ul></h3>
                    </div>
                </div>
            </section>
        
      
            <!-- Sección CUENTAS -->
            <section id="cuentas">
                <div class="cuentas-container-principal">
                    <h2 class="h2Sec">Cuentas</h2>
                    <br>
                    <div class="text-section">
                        <p class="nosotros-description">En CosmicCatStudio ofrecemos diferentes tipos de cuentas que se adaptan a las necesidades de nuestros usuarios. Desde cuentas gratuitas hasta premium, brindamos herramientas y funcionalidades que mejoran la experiencia en la plataforma.</p>
                    </div>
                    <div class="cuentas-container">
                        <div class="cuenta-card">
                            <h3 class="cuenta-title">Cuenta Oyente</h3>
                            <p class="cuenta-description">La cuenta Oyente permite acceder a una amplia gama de música y contenido de artistas emergentes. Ideal para quienes buscan descubrir nuevos talentos.</p>
                            <ul class="cuenta-benefits">
                                <li><ion-icon name="checkmark-circle"></ion-icon> Acceso a playlists exclusivas</li>
                                <li><ion-icon name="checkmark-circle"></ion-icon> Escuchar música sin anuncios</li>
                                <li><ion-icon name="checkmark-circle"></ion-icon> Crear y compartir listas de reproducción</li>
                            </ul>
                        </div>

                        <div class="cuenta-card">
                            <h3 class="cuenta-title">Cuenta Artista</h3>
                            <p class="cuenta-description">La cuenta Artista está diseñada para creadores que desean compartir su música y arte con el mundo. Proporciona herramientas para promocionarse y conectarse con oyentes.</p>
                            <ul class="cuenta-benefits">
                                <li><ion-icon name="checkmark-circle"></ion-icon> Subir y promocionar música</li>
                                <li><ion-icon name="checkmark-circle"></ion-icon> Estadísticas de audiencia</li>
                                <li><ion-icon name="checkmark-circle"></ion-icon> Acceso a recursos de marketing</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección SERVICIOS -->
            <section id="servicios">
                <div class="cuentas-container-principal">
                    <h2 class="h2Sec">Servicios</h2>
                    <br>
                    <div class="text-section">
                        <p class="nosotros-description">Nuestros servicios incluyen desarrollo de videojuegos, plataformas interactivas, y consultoría técnica. Además, ayudamos a crear y gestionar proyectos de arte digital y software para nuestros clientes.</p>
                    </div>
                    <!-- Servicios para Artistas -->
                    <div class="servicio-container">
                        <div class="servicio-box artista-servicios">
                            <h3 class="servicio-titulo">Servicios para Artistas</h3>
                            <ul class="servicio-lista">
                                <li><ion-icon name="brush-outline"></ion-icon> Creación de portfolios personalizados</li>
                                <li><ion-icon name="cloud-upload-outline"></ion-icon> Soporte para la publicación y venta de obras digitales</li>
                                <li><ion-icon name="analytics-outline"></ion-icon> Herramientas de análisis de rendimiento y visibilidad</li>
                                <li><ion-icon name="chatbubbles-outline"></ion-icon> Acceso a mentorías y consultorías técnicas</li>
                            </ul>
                        </div>

                        <!-- Servicios para Oyentes -->
                        <div class="servicio-box oyente-servicios">
                            <h3 class="servicio-titulo">Servicios para Oyentes</h3>
                            <ul class="servicio-lista">
                                <li><ion-icon name="musical-notes-outline"></ion-icon> Acceso a contenido exclusivo de artistas emergentes</li>
                                <li><ion-icon name="heart-outline"></ion-icon> Personalización de recomendaciones de arte y música</li>
                                <li><ion-icon name="gift-outline"></ion-icon> Participación en eventos y sorteos exclusivos</li>
                                <li><ion-icon name="star-outline"></ion-icon> Seguimiento de artistas favoritos y notificaciones personalizadas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>


        </div>

        <!-- Ícono de flecha para subir al inicio -->
        <div class="arrow-up" onclick="scrollToTop()">
            <ion-icon name="arrow-up-outline"></ion-icon>
        </div>
        
    </div>
    <script src="../js/loginTogglePassword.js"></script>
    <script src="../js/arrowWebPage.js"></script>
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <script src="../js/loginbd.js"></script>
    
</body>
</html>