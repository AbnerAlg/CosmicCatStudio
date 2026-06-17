<?php
// Activar reportes de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// Obtener el id del artista desde la URL
$id_art = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$id_art) {
    die("ID del artista no especificado.");
}

// Consulta para obtener los productos del artista, incluyendo imagen_producto
$sql = "SELECT p.nombre AS nombre_producto, p.descripcion, p.stock, p.precio, 
               p.id_producto AS id_producto, p.tipo_imagen, p.imagen_producto, p.id_artista
        FROM producto p
        WHERE p.id_artista = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("i", $id_art);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Productos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../img/logoVentana2.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/style_productos.css">
</head>
<body>
<script>
        
        function irAPagina2(url) {
            window.location.href = url;
        }
    </script>
    <header>
        <div class="contenedor-header">
            <h1 class="logo">
                <a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png" alt=""></a>
            </h1>
            <nav class="navegacion">
                <a class="sin-mod" href="#">Tienda</a>
                <a class="sin-mod" href="comunidad-view-artist.php?id=<?php echo $id_art; ?>">Mi comunidad</a>
                <a class="sin-mod" href="profile.php?id=<?php echo $id_art; ?>" >Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-Main">
            <div class="cabecera-productos">
                <h2>Mis productos</h2>
                <a class="sin-mod" href="subirProductos.php?id=<?php echo $id_art; ?>">Subir productos</a>
            </div>

            <div id="mensaje" class="mensaje"></div>

            <div class="contenedor-productos padding-contenedores">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nombre_producto = htmlspecialchars($row['nombre_producto']);
                        $descripcion = htmlspecialchars($row['descripcion']);
                        $precio = htmlspecialchars($row['precio']);
                        $id_producto = $row['id_producto'];
                        $tipo_imagen = $row['tipo_imagen'];
                        $imagen_producto = $row['imagen_producto'];

                        $imagen_base64 = "data:$tipo_imagen;base64,$imagen_producto";

                        echo "<div class='producto' id='producto-{$id_producto}'>";
                        echo "<img src='{$imagen_base64}' alt='{$nombre_producto}' class='portada'>";
                        echo "<h3 class='nombre'>{$nombre_producto}</h3>";
                        echo "<p class='descripcion'>{$descripcion}</p>";
                        echo "<p class='precio'>Precio: \${$precio}</p>";
                        echo "<div class='overlay-iconos'>";
                        echo "<div class='icono icono-editar'>";
                        echo "    <a href='modificarProductos.php?id_art={$id_art}&id_prod={$id_producto}' class='sin-mod'>";
                        echo "        <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>";
                        echo "            <path stroke='none' d='M0 0h24v24H0z' fill='none'/>";
                        echo "            <path d='M4 20h4l10.5 -10.5a2.828 2.828 0 0 0 -4 -4l-10.5 10.5v4'/>";
                        echo "            <path d='M13.5 6.5l4 4'/>";
                        echo "            <path d='M16 19h6'/>";
                        echo "        </svg>";
                        echo "    </a>";
                        echo "</div>";
                        echo "<div class='icono icono-eliminar'>";
                        echo "    <a href='#' class='sin-mod' onclick='event.preventDefault();mostrarModal(event, {$id_producto})'>";
                        echo "        <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>";
                        echo "            <path stroke='none' d='M0 0h24v24H0z' fill='none'/>";
                        echo "            <circle cx='12' cy='12' r='9'/>";
                        echo "            <path d='M9 12l6 0'/>";
                        echo "        </svg>";
                        echo "    </a>";
                        echo "</div>";
                        echo "</div>"; 
                        echo "</div>";
                    }
                } else {
                    echo "<div class='no-productos'>";
                    echo "<p class='mensaje-no-productos'>Oopss! no tienes productos, ¿Quieres agregar uno?</p>";
                    echo "<a href='subirProductos.php?id=$id_art' class='btn-agregar'>Agregar Producto</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Modal de confirmación de eliminación -->
    <div id="modal-confirmar-eliminacion" style="display: none;">
        <div class="modal-contenido">
            <p>¿Estás seguro de que deseas eliminar este producto?</p>
            <button id="btn-confirmar-eliminar" onclick="eliminarProducto()">Eliminar</button>
            <button onclick="cerrarModal()">Cancelar</button>
        </div>
    </div>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <!-- JavaScript para manejo del modal y eliminación de productos -->
    <script>
        let productoIdParaEliminar = null;

        function mostrarModal(event, idProducto) {
            event.preventDefault();
            productoIdParaEliminar = idProducto;
            document.getElementById('modal-confirmar-eliminacion').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal-confirmar-eliminacion').style.display = 'none';
        }

        async function eliminarProducto() {
            if (!productoIdParaEliminar) return;

            try {
                const response = await fetch(`../php2/eliminarProducto.php?id_prod=${productoIdParaEliminar}`, {
                    method: 'POST',
                });

                const result = await response.json();
                if (result.success) {
                    document.getElementById(`producto-${productoIdParaEliminar}`).remove(); // Elimina el producto del DOM
                    document.getElementById('mensaje').textContent = 'Producto eliminado exitosamente.';
                    document.getElementById('mensaje').classList.remove('mensaje-error');
                    document.getElementById('mensaje').classList.add('mensaje');
                } else {
                    document.getElementById('mensaje').textContent = 'Error al eliminar el producto: ' + result.message;
                    document.getElementById('mensaje').classList.add('mensaje-error');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('mensaje').textContent = "Hubo un problema con la eliminación del producto.";
                document.getElementById('mensaje').classList.add('mensaje-error');
            } finally {
                cerrarModal();
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
