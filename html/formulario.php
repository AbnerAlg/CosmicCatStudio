<?php
$total = isset($_POST['total']) ? $_POST['total'] : '0.00';
$productos = $_POST['productos'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma de pago</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/estilo_formulario.css">
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
                <a class="sin-mod" href="#" onclick="event.preventDefault(); irAPagina('principal.php')">Musica</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('shop.php')">Tienda</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('comunidad.php')">Comunidades</a>
                <a class="sin-mod" href=""
                    onclick="event.preventDefault(); irAPagina('listener_profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main class="contenedor-main">
        <section id="lista-direcciones" class="opcion-direcciones"></section>

        <section class="formulario-direccion" style="display: none;">
            <h2>Dirección de Envío</h2>
            <form id="direccion-form" class="direccion-form">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" required>

                <label for="ciudad">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" required>

                <label for="estado">Estado</label>
                <input type="text" id="estado" name="estado" required>

                <label for="codigo_postal">Código Postal</label>
                <input type="text" id="codigo_postal" name="codigo_postal" required>

                <label for="telefono">Teléfono de Contacto</label>
                <input type="tel" id="telefono" name="telefono" required>

                <button type="submit" class="btn-enviar">Confirmar Dirección</button>
            </form>
        </section>

        <div id="paypal-button-container" style="display: none;"></div>
        <script
            src="https://www.paypal.com/sdk/js?client-id=AbPJGyx-otgSoieJmgCn8-NH-wdo5J89fvCmCVTsTmrSv3-gt-2uUgxG2prqEuaVwiIY_Mc6yNQfWwdN&currency=MXN"></script>
        <script>
            paypal.Buttons({
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '<?php echo $total; ?>' // Monto dinámico recibido desde PHP
                            }
                        }]
                    });
                },
                onApprove: function (data, actions) {
                    return actions.order.capture().then(async function (details) {
                        alert('Pago completado por ' + details.payer.name.given_name);

                        // Datos de productos desde PHP para envío al backend
                        const productos = <?php echo json_encode($productos); ?>;

                        // Enviar datos al backend para actualizar stock
                        const response = await fetch('../php5/actualizar_stock.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ productos })
                        });

                        const result = await response.json();
                        if (result.success) {
                            alert("PAGO REALIZADO CON EXITO");
                            setTimeout(() => {
                                irAPagina('shop.php');
                            }, 2000);
                        } else {
                            alert("Error al actualizar el stock: " + result.message);
                        }
                    });
                }

            }).render('#paypal-button-container');
        </script>


    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const idOyente = urlParams.get("id");
            const listaDirecciones = document.getElementById("lista-direcciones");
            const formularioDireccion = document.querySelector(".formulario-direccion");
            const paypalButtonContainer = document.getElementById("paypal-button-container");

            // Obtener direcciones del oyente
            const response = await fetch(`../php5/obtener_direcciones.php?id=${idOyente}`);
            const direcciones = await response.json();

            if (direcciones.length > 0) {
                listaDirecciones.innerHTML = '<h2>Selecciona una dirección</h2><form id="seleccion-direccion">';
                direcciones.forEach((direccion, index) => {
                    listaDirecciones.innerHTML += `
                <div class="direccion">
                    <input type="radio" id="direccion${index}" name="direccion" value="${direccion.NombreCompleto}" required>
                    <label for="direccion${index}">
                        <p><strong>${direccion.NombreCompleto}</strong></p>
                        <p>${direccion.Direccion}, ${direccion.Ciudad}, ${direccion.Estado}, ${direccion.CodigoP}</p>
                        <p>Tel: ${direccion.Telefono}</p>
                    </label>
                </div>`;
                });
                listaDirecciones.innerHTML += `</form><button class="btn-nueva-direccion">Agregar nueva dirección</button><button id="btn-usar-direccion" style="display: none;">Usar esta dirección</button>`;

                // Obtener el botón "Usar esta dirección" después de crearlo
                const btnUsarDireccion = document.getElementById("btn-usar-direccion");

                // Mostrar botón de PayPal al seleccionar dirección
                document.body.addEventListener("change", (e) => {
                    if (e.target.name === "direccion") {
                        btnUsarDireccion.style.display = "inline-block";
                    }
                });

                // Al hacer clic en usar dirección, muestra el botón de PayPal
                btnUsarDireccion.addEventListener("click", () => {
                    paypalButtonContainer.style.display = "block";
                });
            } else {
                formularioDireccion.style.display = "block";
            }

            // Mostrar formulario para agregar nueva dirección
            document.body.addEventListener("click", (e) => {
                if (e.target.classList.contains("btn-nueva-direccion")) {
                    listaDirecciones.style.display = "none";
                    formularioDireccion.style.display = "block";
                    paypalButtonContainer.style.display = "none";
                }
            });

            // Enviar formulario para guardar nueva dirección
            document.getElementById("direccion-form").addEventListener("submit", async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                formData.append("idOyente", idOyente);

                const response = await fetch('../php5/guardar_direccion.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    alert("Dirección guardada correctamente.");
                    window.location.reload();
                } else {
                    alert("Error al guardar la dirección.");
                }
            });
        });
    </script>
</body>

</html>