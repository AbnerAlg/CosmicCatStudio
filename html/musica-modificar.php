<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Música</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_musica.css">

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
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('misProductos.php');">Mis
                    productos</a>
                <a class="sin-mod" onclick="irAPagina('profile.php')">Perfil</a>
                <a class="sin-mod" onclick="irAPagina('comunidad-view-artist.php')">Mi comunidad</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <h2 class="cabecera-musica">Editar música</h2>
            <div class="formulario-musica">
                <form class="contenedor-formulario" action="tu-servidor-de-edicion" method="post"
                    enctype="multipart/form-data">
                    <label for="archivo-musica">Archivo de música:</label>
                    <input type="text" id="archivo-musica" name="archivo-musica" value="nombre-actual-del-archivo.mp3"
                        readonly required>
                    <label for="titulo-cancion">Título de la canción:</label>
                    <input type="text" id="titulo-cancion" name="titulo-cancion" maxlength="255" required>
                    <label for="genero">Género:</label>
                    <input type="text" id="genero" name="genero" maxlength="255" required>
                    <label for="colaboradores">Colaboradores:</label>
                    <input type="text" id="colaboradores" name="colaboradores" maxlength="255">
                    <label for="letra">Letra:</label>
                    <textarea id="letra" name="letra" rows="4" required></textarea>
                    <label for="foto-representativa">Foto representativa:</label>
                    <input type="file" id="foto-representativa" name="foto-representativa" accept="image/*">
                    <label for="foto-preview">Foto Representativa Actual:</label>
                    <img id="foto-preview" src="" alt="Foto Representativa"
                        style="display: none; width: 150px; height: auto;">
                    <br><br>
                    <div class="contenedor-boton">
                        <button class="boton-subir" type="submit">Guardar cambios</button>
                    </div>
                </form>
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
            const id_musica = new URLSearchParams(window.location.search).get('id_musica');

            try {
                const response = await fetch(`../php5/consulta_cancion.php?id_musica=${id_musica}`);
                const data = await response.json();

                if (data.error) {
                    alert(data.error);
                    return;
                }

                document.getElementById('archivo-musica').value = data.titulo;
                document.getElementById('titulo-cancion').value = data.titulo;
                document.getElementById('genero').value = data.genero;
                document.getElementById('colaboradores').value = data.colaboradores;
                document.getElementById('letra').value = data.letra;

                // Cargar imagen en base64 en el campo de vista previa
                if (data.foto && data.tipo_foto) {
                    const fotoElement = document.getElementById('foto-preview');
                    fotoElement.src = `data:${data.tipo_foto};base64,${data.foto}`;
                    fotoElement.style.display = 'block';
                }
            } catch (error) {
                console.error('Error al cargar los datos de la canción:', error);
            }
        });

        document.querySelector('.contenedor-formulario').addEventListener('submit', async function (event) {
            event.preventDefault(); // Evita el envío estándar del formulario

            const formData = new FormData();
            const id_musica = new URLSearchParams(window.location.search).get('id_musica');
            const titulo = document.getElementById('titulo-cancion').value;
            const genero = document.getElementById('genero').value;
            const colaboradores = document.getElementById('colaboradores').value;
            const letra = document.getElementById('letra').value;
            const fotoRepresentativa = document.getElementById('foto-representativa').files[0];

            // Agregar los datos al FormData
            formData.append('id_musica', id_musica);
            formData.append('titulo-cancion', titulo);
            formData.append('genero', genero);
            formData.append('colaboradores', colaboradores);
            formData.append('letra', letra);

            // Procesar y agregar la foto si se seleccionó una nueva
            if (fotoRepresentativa) {
                const reader = new FileReader();
                reader.onload = async function (e) {
                    const fotoBase64 = e.target.result.split(',')[1]; // base64 sin el encabezado

                    formData.append('foto', fotoBase64); // Cambiado a "foto" para coincidir en PHP
                    formData.append('tipo_foto', fotoRepresentativa.type);

                    // Enviar los datos al backend
                    await enviarDatos(formData);
                };
                reader.readAsDataURL(fotoRepresentativa);
            } else {
                // Si no se selecciona una nueva foto, solo enviar los datos de texto
                await enviarDatos(formData);
            }
        });


        // Función para enviar los datos con fetch
        async function enviarDatos(formData) {
            try {
                const response = await fetch('../php5/actualizar_cancion.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.text();
                alert(result); // Mostrar el resultado

                if (response.ok) {
                    // Redirigir o realizar otra acción tras la actualización exitosa
                    window.location.href = `profile.php?id=${new URLSearchParams(window.location.search).get('id_artista')}`;
                }
            } catch (error) {
                console.error('Error al actualizar la canción:', error);
                alert('Error al actualizar la canción.');
            }
        }
    </script>



</body>

</html>