<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Album</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_crearalbum.css">
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
                        alt=""></a></h1>
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
        <div class="contenedor-formulario">
            <h2>Crear Nuevo Álbum</h2>
            <form id="form-album">
                <label for="nombre-album">Nombre del Álbum</label>
                <input type="text" id="nombre-album" name="nombre_album" required>

                <label for="descripcion-album">Descripción</label>
                <textarea id="descripcion-album" name="descripcion" rows="3" required></textarea>

                <label for="foto-album">Foto del Álbum</label>
                <input type="file" id="foto-album" name="foto" accept="image/*" required>
                <img id="vista-previa" class="vista-previa-img" style="display:none"
                    alt="Vista previa de la foto del álbum">

                <button type="button" onclick="crearAlbum()">Crear Álbum</button>
            </form>

            <div class="lista-canciones" id="lista-canciones">
                <h3>Selecciona Canciones para el Álbum</h3>
                <!-- Aquí se cargarán las canciones dinámicamente -->
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const id_artista = new URLSearchParams(window.location.search).get('id');
            const cancionesSeleccionadas = new Set(); // Set para almacenar canciones seleccionadas
            let fotoAlbumBase64 = ''; // Variable para almacenar la imagen en base64

            // Vista previa de la imagen del álbum y conversión a base64
            document.getElementById('foto-album').addEventListener('change', function (event) {
                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = function () {
                    const preview = document.getElementById('vista-previa');
                    preview.src = reader.result;
                    preview.style.display = 'block';
                    fotoAlbumBase64 = reader.result.split(',')[1]; // Extrae solo el base64, sin el encabezado
                };

                if (file) {
                    reader.readAsDataURL(file); // Leer archivo como base64
                }
            });

            // Función para cargar canciones sin álbum
            async function cargarCanciones() {
                const response = await fetch(`../php5/obtener_canciones_sin_album.php?id_artista=${id_artista}`);
                const canciones = await response.json();
                const listaCanciones = document.getElementById('lista-canciones');
                listaCanciones.innerHTML = ''; // Limpiar la lista para evitar duplicados

                canciones.forEach(cancion => {
                    const cancionDiv = document.createElement('div');
                    cancionDiv.classList.add('cancion-item');
                    cancionDiv.innerHTML = `
                <div class="cancion-detalle">
                    <img src="data:${cancion.tipo_foto};base64,${cancion.foto}" alt="Foto de la canción">
                    <p>${cancion.nombre}</p>
                </div>
                <button type="button" onclick="toggleCancion(${cancion.id_musica}, this)">
                    ${cancionesSeleccionadas.has(cancion.id_musica) ? 'Quitar del Álbum' : 'Agregar al Álbum'}
                </button>
            `;
                    listaCanciones.appendChild(cancionDiv);
                });
            }

            // Alternar selección de canciones sin recargar la lista completa
            window.toggleCancion = function (id_musica, boton) {
                if (cancionesSeleccionadas.has(id_musica)) {
                    cancionesSeleccionadas.delete(id_musica);
                    boton.textContent = 'Agregar al Álbum';
                } else {
                    cancionesSeleccionadas.add(id_musica);
                    boton.textContent = 'Quitar del Álbum';
                }
            };

            // Función para enviar datos y crear el álbum
            window.crearAlbum = async function () {
                const formData = new FormData();
                formData.append('nombre_album', document.getElementById('nombre-album').value);
                formData.append('descripcion', document.getElementById('descripcion-album').value);
                formData.append('foto_base64', fotoAlbumBase64); // Enviar la imagen en base64
                formData.append('id_artista', id_artista);
                formData.append('canciones', JSON.stringify(Array.from(cancionesSeleccionadas)));

                const response = await fetch('../php5/guardar_album.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    alert('Álbum creado con éxito');
                    window.location.href = `profile.php?id=${id_artista}`;
                } else {
                    alert('Error al crear el álbum');
                }
            };

            // Llamada inicial para cargar canciones al iniciar la página
            cargarCanciones();
        });

    </script>
</body>

</html>