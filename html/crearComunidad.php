<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Comunidad</title>
    <link rel="stylesheet" href="../css/styles_subidaProductos.css">
    <link rel="stylesheet" href="../css/crearComunidad.css">
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
        <div class="container-header">
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png"
                        alt=""></a></h1>
            <nav class="navegacion">
                <a class="sin-mod" href="#">Musica</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('misProductos.php');">Mis
                    productos</a>
                <a class="sin-mod" onclick="irAPagina('profile.php')">Perfil</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-Main">
            <div class="subida-Producto">
                <h2 id="titulo">Crear Comunidad</h2>
            </div>
            <div class="contenedor-Productos" id="contenedor-formulario">
                <!-- Aquí se cargará el formulario o el mensaje -->
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&copy; 2024 Tu Tienda. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Overlay para mostrar mensajes -->
    <div id="overlay" class="overlay" onclick="cerrarOverlay(event)">
        <div id="mensaje-overlay" class="mensaje-overlay"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const idArtista = new URLSearchParams(window.location.search).get('id');

            // Verificar si el artista ya tiene comunidad
            fetch(`../php5/verificar_comunidad.php?id=${idArtista}`)
                .then(response => response.json())
                .then(data => {
                    const contenedorFormulario = document.getElementById('contenedor-formulario');
                    if (data.existe) {
                        // Si ya tiene comunidad, mostrar mensaje
                        contenedorFormulario.innerHTML = '<p>Parece que ya tienes una comunidad.</p>';
                    } else {
                        // Si no tiene comunidad, mostrar el formulario
                        contenedorFormulario.innerHTML = `
                        <form id="form-comunidad">
                            <div class="campo">
                                <label for="nombre">Nombre de la comunidad:</label>
                                <input type="text" id="nombre" name="nombre" required>
                            </div>
                            <div class="campo">
                                <label for="descripcion">Descripción:</label>
                                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                            </div>
                            <div class="campo">
                                <label for="imagen">Imagen de la comunidad:</label>
                                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn-subir">Crear comunidad</button>
                        </form>
                    `;

                        document.getElementById('form-comunidad').addEventListener('submit', crearComunidad);
                    }
                })
                .catch(error => console.error('Error:', error));
        });



        // Función para crear la comunidad
        async function crearComunidad(event) {
            event.preventDefault();

            const idArtista = new URLSearchParams(window.location.search).get('id');
            const nombre = document.getElementById('nombre').value;
            const descripcion = document.getElementById('descripcion').value;
            const imagenInput = document.getElementById('imagen');
            const imagen = imagenInput.files[0];

            if (!imagen) {
                mostrarOverlay('Por favor, selecciona una imagen.');
                return;
            }

            // Convertir la imagen a base64
            const base64Imagen = await convertirImagenBase64(imagen);

            // Dividir el base64 en tipo y contenido
            const { mimeType, base64Data } = dividirBase64(base64Imagen);

            const formData = {
                nombre: nombre,
                descripcion: descripcion,
                foto: base64Data,
                tipo_foto: mimeType,
                id_artista: idArtista
            };

            fetch(`../php5/subir_comunidad.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarOverlay('¡Comunidad creada exitosamente!', true, idArtista);
                    } else {
                        mostrarOverlay('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Convertir imagen a base64
        function convertirImagenBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onloadend = () => resolve(reader.result);
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

        // Función para dividir base64 en tipo y contenido
        function dividirBase64(base64String) {
            const parts = base64String.split(',');
            const mimeType = parts[0].match(/:(.*?);/)[1];
            const base64Data = parts[1];
            return { mimeType, base64Data };
        }

        // Mostrar overlay con mensaje
        function mostrarOverlay(mensaje, redirigir = false, idArtista = null) {
            const overlay = document.getElementById('overlay');
            const mensajeOverlay = document.getElementById('mensaje-overlay');
            mensajeOverlay.textContent = mensaje;
            overlay.style.display = 'block';

            if (redirigir) {
                setTimeout(() => {
                    window.location.href = `comunidad-view-artist.php?id=${idArtista}`;
                }, 3000);
            }
        }

        // Cerrar overlay manualmente
        function cerrarOverlay(event) {
            const overlay = document.getElementById('overlay');
            overlay.style.display = 'none';
        }
    </script>
</body>

</html>