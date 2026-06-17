<?php
require '../php5/editardatos.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_editProfile.css">
    <link rel="stylesheet" href="../css/modal.css">
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
        <div class="container-header">
            <h1 class="logo"><a class="sin-mod"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt="CosmicCatStudio"></a></h1>
            <nav class="navegacion">
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('misProductos.php');">Mis
                    productos</a>
                <a class="sin-mod" onclick="irAPagina('profile.php')">Perfil</a>
                <a class="sin-mod" onclick="irAPagina('comunidad-view-artist.php')">Mi comunidad</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-Main">
            <div class="modificacion-editar">
                <h2>Editar Perfil</h2>
            </div>
            <div class="contenedor-editar">
                <!-- Contenedor que agrupa la foto y los campos -->
                <div class="contenedor-foto-y-campos">
                    <!-- Foto de perfil al lado izquierdo -->
                    <div class="campo imagen-lateral">
                        <label for="foto">Foto:</label>
                        <div class="imagen-perfil">
                            <?php if (!empty($avatar)): ?>
                                <img id="imagen-previa"
                                    src="data:image/jpeg;base64,<?php echo htmlspecialchars($avatar); ?>"
                                    alt="Imagen de perfil">
                            <?php else: ?>
                                <img id="imagen-previa" src="../img/sinFotoperfil.jpg" alt="Imagen de perfil">
                            <?php endif; ?>
                        </div>
                        <input type="file" id="foto" name="foto" accept="image/*" onchange="mostrarPrevia(event)"
                            class="input-archivo">
                        <label for="foto" class="btn-editar" style="text-align: center">Editar Foto</label>

                        <label for="foto-banner">Banner:</label>
                        <div class="imagen-banner">
                            <?php if (!empty($banner)): ?>
                                <img id="imagen-previa-banner"
                                    src="data:image/jpeg;base64,<?php echo htmlspecialchars($banner); ?>"
                                    alt="Imagen de perfil">
                            <?php else: ?>
                                <img id="imagen-previa-banner" src="../img/sinFotoperfil.jpg" alt="Imagen de perfil">
                            <?php endif; ?>
                        </div>
                        <input type="file" id="foto-banner" name="fotoB" accept="image/*"
                            onchange="mostrarPreviaBanner(event)" class="input-archivo">
                        <label for="foto-banner" class="btn-editar" style="text-align: center">Editar Foto</label>
                    </div>

                    <!-- Inputs del formulario a la derecha -->
                    <div class="campo-editar">
                        <div class="campo">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre"
                                value="<?php echo htmlspecialchars($nombre); ?>" required>
                        </div>

                        <div class="campo">
                            <label for="nombre_artistico">Nombre Artístico:</label>
                            <input type="text" id="nombre_artistico" name="nombre_artistico"
                                value="<?php echo htmlspecialchars($nombre_artistico); ?>" required>
                        </div>

                        <div class="campo">
                            <label for="edad">Edad:</label>
                            <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($edad); ?>"
                                required>
                        </div>

                        <div class="campo">
                            <label for="nacionalidad">Nacionalidad:</label>
                            <input type="text" id="nacionalidad" name="nacionalidad"
                                value="<?php echo htmlspecialchars($nacionalidad); ?>" required>
                        </div>

                        <div class="campo">
                            <label for="gnrMusical">Genero Musical:</label>
                            <input type="text" id="gnrMusical" name="genero"
                                value="<?php echo htmlspecialchars($genero); ?>" required>
                        </div>

                        <div class="campo">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" rows="4"
                                required><?php echo htmlspecialchars($descripcion); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Botón para enviar el formulario -->
                <button type="button" onclick="submitForm()" class="btn-modificar">Editar Perfil</button>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&copy; 2024 Tu Perfil Artista. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Modal de confirmación -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Confirmación de Cambios</h3>
            <p>¿Estás seguro de que deseas realizar los siguientes cambios?</p>
            <div id="modalChanges"></div>
            <button onclick="submitForm()">Aceptar</button>
            <button onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <script src="../js/script_editProfileOyente.js"></script>
    <script>
        // Función para capturar y convertir la imagen a base64 al enviar el formulario

        // Cargar los datos cuando la página se carga
        document.addEventListener("DOMContentLoaded", function () {
            const id = new URLSearchParams(window.location.search).get('id');

            fetch(`../php5/editardatos.php?id=${id}`, {
                method: 'GET',
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Rellenar los campos del formulario con los datos recibidos
                        document.getElementById('nombre').value = data.data.nombre;
                        document.getElementById('nombre_artistico').value = data.data.nombre_artistico;
                        document.getElementById('edad').value = data.data.edad;
                        document.getElementById('nacionalidad').value = data.data.nacionalidad;
                        document.getElementById('gnrMusical').value = data.data.genero;
                        document.getElementById('descripcion').value = data.data.descripcion;

                        // Mostrar la imagen si existe
                        if (data.data.avatar) {
                            document.getElementById('imagen-previa').src = `data:${data.data.tipo_avatar};base64,${data.data.avatar}`;
                        }
                        if (data.data.banner) {
                            document.getElementById('imagen-previa-banner').src = `data:${data.data.tipo_banner};base64,${data.data.banner}`;
                        }
                    } else {
                        alert('Error al cargar los datos: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un problema al cargar los datos.');
                });
        });

        // Función para enviar el formulario
        function getBase64FromInputFile() {
            return new Promise((resolve, reject) => {
                const fileInput = document.getElementById('foto'); // Capturamos el input de la imagen
                const file = fileInput.files[0]; // Obtenemos el archivo seleccionado

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const base64String = e.target.result;
                        resolve(base64String); // Resolvemos la promesa con el resultado en base64
                    };
                    reader.onerror = function (error) {
                        reject('Error al convertir la imagen a base64: ' + error);
                    };
                    reader.readAsDataURL(file); // Leer el archivo como base64
                } else {
                    resolve(null); // Si no hay archivo seleccionado, devolvemos null
                }
            });
        }


        function getBase64FromInputFileBanner() {
            return new Promise((resolve, reject) => {
                const fileInput = document.getElementById('foto-banner'); // Capturamos el input de la imagen
                const file = fileInput.files[0]; // Obtenemos el archivo seleccionado

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const base64StringBanner = e.target.result;
                        resolve(base64StringBanner); // Resolvemos la promesa con el resultado en base64
                    };
                    reader.onerror = function (error) {
                        reject('Error al convertir la imagen a base64: ' + error);
                    };
                    reader.readAsDataURL(file); // Leer el archivo como base64
                } else {
                    resolve(null); // Si no hay archivo seleccionado, devolvemos null
                }
            });
        }


        // Función para dividir la cadena base64 en el tipo MIME y el contenido
        function splitBase64(base64String) {
            if (!base64String) {
                return { mimeType: null, base64Data: null };
            }

            // La cadena base64 tiene el formato "data:image/jpeg;base64,xxxxxxxxxx"
            const parts = base64String.split(',');
            const mimeType = parts[0].match(/:(.*?);/)[1]; // Extraemos el tipo MIME
            const base64Data = parts[1]; // Extraemos la parte de la imagen codificada

            return { mimeType, base64Data };
        }

        function splitBase64Banner(base64StringBanner) {
            if (!base64StringBanner) {
                return { mimeTypeBanner: null, base64DataBanner: null };
            }

            const parts = base64StringBanner.split(',');
            const mimeTypeBanner = parts[0].match(/:(.*?);/)[1];
            const base64DataBanner = parts[1];

            return { mimeTypeBanner, base64DataBanner };
        }

        // Función para enviar el formulario
        async function submitForm() {
            const id = new URLSearchParams(window.location.search).get('id');
            const base64StringBanner = await getBase64FromInputFileBanner();
            const { mimeTypeBanner, base64DataBanner } = splitBase64Banner(base64StringBanner);

            const base64String = await getBase64FromInputFile();
            const { mimeType, base64Data } = splitBase64(base64String);



            let formData = {
                nombre: document.getElementById('nombre').value,
                nombre_artistico: document.getElementById('nombre_artistico').value,
                edad: document.getElementById('edad').value,
                nacionalidad: document.getElementById('nacionalidad').value,
                genero: document.getElementById('gnrMusical').value,
                descripcion: document.getElementById('descripcion').value,
                avatar: base64Data ? base64Data : null,  // Enviar solo si existe
                tipo_avatar: mimeType ? mimeType : null, // Enviar solo si existe
                banner: base64DataBanner ? base64DataBanner : null,
                tipo_banner: mimeTypeBanner ? mimeTypeBanner : null
            };

            fetch(`../php5/editardatos.php?id=${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Datos actualizados correctamente.');
                    } else {
                        alert('Error al actualizar los datos: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un problema con la actualización.');
                });
        }
    </script>
</body>

</html>