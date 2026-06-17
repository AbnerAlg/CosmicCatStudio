<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil de Oyente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_editProfile.css">
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
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
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
                <div class="contenedor-foto-y-campos">
                    <div class="campo imagen-lateral">
                        <label for="foto">Foto de Perfil:</label>
                        <div class="imagen-perfil">
                            <img id="imagen-previa" src="../img/sinFotoperfil.jpg" alt="Imagen de perfil">
                        </div>
                        <input type="file" id="foto" name="foto" accept="image/*" onchange="mostrarPrevia(event)"
                            class="input-archivo">
                        <label for="foto" class="btn-editar" style="text-align: center">Editar Foto</label>

                        <label for="foto-banner">Banner:</label>
                        <div class="imagen-banner">
                            <img id="imagen-previa-banner" src="../img/sinFotoperfil.jpg" alt="Imagen de banner">
                        </div>
                        <input type="file" id="foto-banner" name="fotoB" accept="image/*"
                            onchange="mostrarPreviaBanner(event)" class="input-archivo">
                        <label for="foto-banner" class="btn-editar" style="text-align: center">Editar Banner</label>
                    </div>

                    <div class="campo-editar">
                        <div class="campo">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>

                        <div class="campo">
                            <label for="edad">Edad:</label>
                            <input type="number" id="edad" name="edad" required>
                        </div>

                        <div class="campo">
                            <label for="nacionalidad">Nacionalidad:</label>
                            <input type="text" id="nacionalidad" name="nacionalidad" required>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="submitForm()" class="btn-modificar">Guardar Cambios</button>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&copy; 2024 CosmicCatStudio. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="../js/script_editProfileOyente.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const id = new URLSearchParams(window.location.search).get('id');

            fetch(`../php5/editardatosoyente.php?id=${id}`, {
                method: 'GET',
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('nombre').value = data.data.nombre;
                        document.getElementById('edad').value = data.data.edad;
                        document.getElementById('nacionalidad').value = data.data.nacionalidad;

                        if (data.data.avatar) {
                            document.getElementById('imagen-previa').src = `data:${data.data.avatar_tipo};base64,${data.data.avatar}`;
                        }
                        if (data.data.banner) {
                            document.getElementById('imagen-previa-banner').src = `data:${data.data.banner_tipo};base64,${data.data.banner}`;
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

        async function getBase64FromInputFile(inputId) {
            const fileInput = document.getElementById(inputId);
            const file = fileInput.files[0];
            if (file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        resolve(e.target.result);
                    };
                    reader.onerror = function (error) {
                        reject('Error al convertir la imagen a base64: ' + error);
                    };
                    reader.readAsDataURL(file);
                });
            }
            return null;
        }

        function splitBase64(base64String) {
            if (!base64String) return { mimeType: null, base64Data: null };
            const parts = base64String.split(',');
            return {
                mimeType: parts[0].match(/:(.*?);/)[1],
                base64Data: parts[1]
            };
        }

        async function submitForm() {
            const id = new URLSearchParams(window.location.search).get('id');

            const base64Avatar = await getBase64FromInputFile('foto');
            const { mimeType: avatarType, base64Data: avatarData } = splitBase64(base64Avatar);

            const base64Banner = await getBase64FromInputFile('foto-banner');
            const { mimeType: bannerType, base64Data: bannerData } = splitBase64(base64Banner);

            const formData = {
                nombre: document.getElementById('nombre').value,
                edad: document.getElementById('edad').value,
                nacionalidad: document.getElementById('nacionalidad').value,
                avatar: avatarData || null,
                avatar_tipo: avatarType || null,
                banner: bannerData || null,
                banner_tipo: bannerType || null
            };

            fetch(`../php5/editardatosoyente.php?id=${id}`, {
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