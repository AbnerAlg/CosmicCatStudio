<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Música</title>
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
                        alt=""></a></h1>
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
        <div class="contenedor-main">
            <h2 class="cabecera-musica">Subir Música</h2>
            <div class="formulario-musica">
                <form class="contenedor-formulario" id="form-subir-musica" enctype="multipart/form-data">
                    <label for="archivo-musica">Elige tu archivo de música:</label>
                    <input type="file" id="archivo-musica" name="archivo-musica" accept=".mp3,.FLAC,.AAC,.WAV,.AIFF"
                        required>

                    <label for="titulo-cancion">Título de la canción:</label>
                    <input type="text" id="titulo-cancion" name="titulo-cancion" maxlength="255" required>

                    <label for="genero">Género:</label>
                    <input type="text" id="genero" name="genero" maxlength="255" required>

                    <label for="colaboradores">Colaboradores:</label>
                    <input type="text" id="colaboradores" name="colaboradores" maxlength="255">

                    <label for="letra">Letra:</label>
                    <textarea id="letra" name="letra" rows="4" required></textarea>

                    <label for="foto-representativa">Foto representativa:</label>
                    <input type="file" id="foto-representativa" accept="image/*" required>

                    <br><br>
                    <div class="contenedor-boton">
                        <button class="boton-subir" type="submit">Subir</button>
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
        document.getElementById('form-subir-musica').addEventListener('submit', async function (event) {
            event.preventDefault();

            const formData = new FormData();
            const archivoMusica = document.getElementById('archivo-musica').files[0];
            const fotoRepresentativa = document.getElementById('foto-representativa').files[0];
            const id_artista = new URLSearchParams(window.location.search).get('id');

            if (archivoMusica && fotoRepresentativa) {
                // Convertir archivo de música a Base64
                const readerArchivo = new FileReader();
                readerArchivo.onload = async function (e) {
                    const musicaBase64 = e.target.result.split(',')[1];

                    // Convertir foto a Base64
                    const readerFoto = new FileReader();
                    readerFoto.onload = async function (e) {
                        const fotoBase64 = e.target.result.split(',')[1];

                        formData.append('archivo-musica', musicaBase64);
                        formData.append('tipo_musica', archivoMusica.type);  // Tipo MIME
                        formData.append('titulo', document.getElementById('titulo-cancion').value);
                        formData.append('genero', document.getElementById('genero').value);
                        formData.append('colaboradores', document.getElementById('colaboradores').value);
                        formData.append('letra', document.getElementById('letra').value);
                        formData.append('foto', fotoBase64);
                        formData.append('tipo_foto', fotoRepresentativa.type);
                        formData.append('id_artista', id_artista);

                        // Enviar los datos a subir_musica.php
                        try {
                            const response = await fetch('../php5/subir_musica.php', {
                                method: 'POST',
                                body: formData
                            });

                            const result = await response.text();
                            alert(result); // Mostrar el resultado

                            // Redirigir a profile.php con el ID del artista
                            if (response.ok) {
                                window.location.href = `profile.php?id=${id_artista}`;
                            }
                        } catch (error) {
                            console.error('Error al subir la música:', error);
                            alert('Error al subir la música.');
                        }
                    };
                    readerFoto.readAsDataURL(fotoRepresentativa);
                };
                readerArchivo.readAsDataURL(archivoMusica);
            }
        });

    </script>
</body>

</html>