<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Productos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/styles_subidaProductos.css">
    <link rel="stylesheet" href="../css/style_productos.css">
</head>

<body>
    <script>
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
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('misProductos.php')">Mis
                    Productos</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('comunidad-view-artist.php')">Mi
                    comunidad</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('profile.php')">Perfil</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-Main">
            <div class="subida-Producto">
                <h2>Subir Producto</h2>
            </div>
            <div class="contenedor-Productos">
                <form id="product-form" enctype="multipart/form-data">
                    <div class="campo">
                        <label for="nombre">Nombre del Producto:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                    </div>
                    <div class="campo">
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" required>
                    </div>
                    <div class="campo">
                        <label for="precio">Precio (sin IVA):</label>
                        <input type="number" id="precio" name="precio" required>
                    </div>
                    <div class="campo">
                        <label for="imagen">Imagen del Producto:</label>
                        <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png, image/webp"
                            required>
                    </div>
                    <button type="submit" class="btn-subir">Subir Producto</button>
                </form>
                <div id="success-message" style="display:none;">Producto subido exitosamente.</div>
                <div id="error-message" style="display:none;">Hubo un error al subir el producto.</div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&copy; 2024 Tu Tienda. Todos los derechos reservados.</p>
        </div>
    </footer>
    <style>
        textarea {
            resize: none;
        }
    </style>

    <script>
        function irAPagina(url) {
            const idArtista = new URLSearchParams(window.location.search).get('id');
            window.location.href = url + `?id=${idArtista}`;
        }
        // Función para capturar y convertir la imagen a base64
        function getBase64FromInputFile() {
            return new Promise((resolve, reject) => {
                const fileInput = document.getElementById('imagen'); // Capturamos el input de la imagen
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

        async function submitForm(event) {
            event.preventDefault();

            const idArtista = new URLSearchParams(window.location.search).get('id');
            const base64String = await getBase64FromInputFile();
            const { mimeType, base64Data } = splitBase64(base64String);

            // Crear objeto de datos para enviar en el cuerpo de la solicitud
            const formData = {
                id_artista: idArtista,
                nombre: document.getElementById('nombre').value,
                descripcion: document.getElementById('descripcion').value,
                stock: document.getElementById('stock').value,
                precio: document.getElementById('precio').value,
                imagen: base64Data,
                tipo_imagen: mimeType
            };

            // Enviar los datos en formato JSON
            fetch('../php2/subir_producto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('success-message').textContent = data.message;
                        document.getElementById('success-message').style.display = 'block';

                        setTimeout(() => {
                            window.location.href = 'misProductos.php' + `?id=${idArtista}`;
                        }, 3000);
                    } else {
                        document.getElementById('error-message').textContent = data.message;
                        document.getElementById('error-message').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('error-message').textContent = "Hubo un problema con la subida del producto.";
                    document.getElementById('error-message').style.display = 'block';
                });
        }

        document.getElementById('product-form').addEventListener('submit', submitForm);
    </script>
</body>

</html>