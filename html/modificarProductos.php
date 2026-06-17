<?php
// Mostrar errores de PHP para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el id del artista y del producto desde la URL
$id_art = isset($_GET['id_art']) ? (int) $_GET['id_art'] : null;
$id_prod = isset($_GET['id_prod']) ? (int) $_GET['id_prod'] : null;

if (!$id_art || !$id_prod) {
    die("ID del artista o producto no especificado.");
}

// Consulta para obtener los datos actuales del producto
$sql = "SELECT nombre, descripcion, stock, precio FROM producto WHERE id_producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_prod);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el producto
if ($result->num_rows === 0) {
    die("Producto no encontrado.");
}

$producto = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/modificar.css">
</head>

<body>
    <script>
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
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-Main">
            <div class="modificacion-Producto">
                <h2>Modificar Producto</h2>
            </div>
            <div class="contenedor-Productos">
                <form id="modificar-form" enctype="multipart/form-data">
                    <div class="campo">
                        <label for="nombre">Nombre del Producto:</label>
                        <input type="text" id="nombre" name="nombre"
                            value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                    </div>
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                            required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                    </div>
                    <div class="campo">
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock"
                            value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
                    </div>
                    <div class="campo">
                        <label for="precio">Precio (sin IVA):</label>
                        <input type="number" id="precio" name="precio"
                            value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                    </div>
                    <div class="campo">
                        <label for="foto_representativa">Cambiar foto representativa (opcional):</label>
                        <input type="file" id="foto_representativa" name="foto_representativa" accept="image/*">
                    </div>
                    <button type="submit" class="btn-modificar" onclick="submitForm(event)">Modificar Producto</button>
                </form>

                <div id="success-message" style="display:none; color: green;">Producto modificado exitosamente.</div>
                <div id="error-message" style="display:none; color: red;">Hubo un error al modificar el producto.</div>
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
            /* Evita que el usuario ajuste el tamaño */
        }
    </style>


    <script>
        document.getElementById('modificar-form').addEventListener('submit', submitForm);

        async function submitForm(event) {
            event.preventDefault();

            const form = document.getElementById('modificar-form');
            const formData = new FormData(form);

            const idArt = "<?php echo $id_art; ?>";
            const idProd = "<?php echo $id_prod; ?>";

            const fileInput = document.getElementById('foto_representativa');
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const base64Image = await toBase64(file);
                const mimeType = file.type;

                formData.append('imagen_producto', base64Image);
                formData.append('tipo_imagen', mimeType);
            }

            fetch(`../php2/modificar_Productos.php?id_art=${idArt}&id_prod=${idProd}`, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('success-message').style.display = 'block';
                        setTimeout(() => {
                            window.location.href = `misProductos.php?id=${idArt}`;
                        }, 3000);
                    } else {
                        document.getElementById('error-message').textContent = data.message;
                        document.getElementById('error-message').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('error-message').textContent = "Hubo un problema con la modificación del producto.";
                    document.getElementById('error-message').style.display = 'block';
                });
        }

        // Función para convertir la imagen a base64
        function toBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result.split(',')[1]);
                reader.onerror = error => reject(error);
            });
        }
    </script>




</body>

</html>