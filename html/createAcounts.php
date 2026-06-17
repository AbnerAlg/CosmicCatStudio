<!-- ACOUNTS TYPES -->
<?php
require '../php5/crearCuenta.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta CosmicCatStudio</title>
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styleCreateAcounts.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="navbar">
        <div class="icon">
            <a href="../html/webPagelogin.html"><img src="../img/logoPagPrincipal.png" alt="Logo" class="logo"></a>
        </div>
        <div class="menu">
            <ul>
                <li>Tipos de Cuentas</li>
            </ul>
        </div>
    </div>

    <div class="cotn_principal">
        <div class="cont_centrar">
            <div class="cont_login">
                <div class="cont_info_log_sign_up">
                    <div class="col_md_login">
                        <div class="cont_ba_opcitiy">
                            <h2>OYENTE</h2>
                            <p>Escucha miles de canciones y descubre artistas emergentes</p>
                            <button class="btn_login" onclick="change_to_login()">Crear Cuenta Oyente</button>
                        </div>
                    </div>
                    <!-- ARTIST -->
                    <div class="col_md_sign_up">
                        <div class="cont_ba_opcitiy">
                            <h2>ARTISTA</h2>
                            <p>Distribuye música y <br> compartela con el mundo</p>
                            <button class="btn_sign_up" onclick="change_to_sign_up()">Crear Cuenta Artista</button>
                        </div>
                    </div>
                </div>

                <div class="cont_back_info">
                    <div class="cont_img_back_grey">
                        <img src="https://images.unsplash.com/42/U7Fc1sy5SCUDIu4tlJY3_NY_by_PhilippHenzler_philmotion.de.jpg?ixlib=rb-0.3.5&q=50&fm=jpg&crop=entropy&s=7686972873678f32efaf2cd79671673d" alt="" />
                    </div>
                </div>

                <div class="cont_forms">
                    <div class="cont_img_back_">
                        <img src="https://images.unsplash.com/42/U7Fc1sy5SCUDIu4tlJY3_NY_by_PhilippHenzler_philmotion.de.jpg?ixlib=rb-0.3.5&q=50&fm=jpg&crop=entropy&s=7686972873678f32efaf2cd79671673d" alt="" />
                    </div>

                    <!-- FORMULARIO OYENTE -->
                    <div class="cont_form_login">
                        <a href="#" onclick="hidden_login_and_sign_up()" style="text-decoration: none; font-size: 16px"><b>←</b></a>
                        <h2>CUENTA OYENTE</h2>
                        <input type="text" id="correo" placeholder="Correo" />
                        <input type="text" id="nombre" placeholder="Nombre" />
                        <input type="number" id="edad" placeholder="Edad" />
                        <input type="password" id="contrasena" placeholder="Contraseña" />
                        <input type="password" id="confirmar_contrasena" placeholder="Confirmar Contraseña" />
                        <button class="btn_login" id="crear_btn" onclick="crearCuentaOyente()">CREAR</button>
                    </div>

                    <div class="cont_form_sign_up">
                        <a href="#" onclick="hidden_login_and_sign_up()" style="text-decoration: none; font-size: 16px"><b>←</b></a>
                        <!-- FORMULARIO ARTISTA (NO LO TOCAMOS) -->
                        <h2>CUENTA ARTISTA</h2>
                        <input type="text" id="artista-correo" placeholder="Correo" />
                        <input type="text" id="artista-nombre" placeholder="Nombre" />
                        <input type="text" id="artista-artistico" placeholder="Nombre Artístico" />
                        <input type="text" id="artista-edad" placeholder="Edad" />
                        <input type="text" id="artista-nacionalidad" placeholder="Nacionalidad" />
                        <input type="password" id="artista-contrasena" placeholder="Contraseña" />
                        <input type="password" id="artista-contrasena-confirmar" placeholder="Confirmar Contraseña" />
                        <button class="btn_sign_up" id="artista-boton" onclick="change_to_sign_up()">CREAR</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Overlay para mensajes de error o éxito -->
    <div id="overlay" class="overlay" style="display: none;">
        <div class="overlay-content">
            <div class="overlay-box">
                <p id="overlay-message">Cargando...</p>
            </div>
        </div>
    </div>
    <script src="../js/scriptCreateAcountS.js"></script>

    <script>
    function crearCuentaOyente() {
        const correo = document.getElementById('correo').value;
        const nombre = document.getElementById('nombre').value;
        const edad = document.getElementById('edad').value;
        const contrasena = document.getElementById('contrasena').value;
        const confirmar_contrasena = document.getElementById('confirmar_contrasena').value;

        const datosOyente = {
            correo: correo,
            nombre: nombre,
            edad: edad,
            contrasena: contrasena,
            confirmar_contrasena: confirmar_contrasena
        };

        fetch('../php5/crearCuentaOyente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosOyente)
        })
        .then(response => response.json())
        .then(data => {
            const overlayMessage = document.getElementById('overlay-message');
            const overlay = document.getElementById('overlay');

            if (data.error) {
                overlayMessage.textContent = `Error: ${data.message}`;
                overlay.style.display = 'block';
            } else {
                overlayMessage.textContent = data.message;
                overlay.style.display = 'block';
                setTimeout(() => {
                    overlay.style.display = 'none';
                    window.location.href = 'login.html'; // Redirigir al login o a otra página
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const overlayMessage = document.getElementById('overlay-message');
            const overlay = document.getElementById('overlay');
            overlayMessage.textContent = 'Hubo un problema al crear la cuenta.';
            overlay.style.display = 'block';
        });
    }
    </script>
    
</body>

</html>