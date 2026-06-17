


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style_comunidad.css">
</head>
<body>
    <header>
        <div class="contenedor-header">
            <h1 class="logo"><a class="sin-mod" href="#"><img class="logo-img" src="../img/LOGO-corregido.png" alt=""></a></h1>
            <nav class="navegacion">
                <a class="sin-mod" href="">Musica</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('misProductos.php')">Mis productos</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina('profile.php')">Perfil</a>
                <a class="sin-mod" href="" onclick="event.preventDefault(); irAPagina2('webPagelogin.php')">🔒<span>Cerrar sesión</span></a>
            </nav>
        </div>
    </header>

    <main>
        <div class="contenedor-main">
            <div class="contenedor-comunidad" id="comunidad-container">
                <!-- Aquí se cargarán los datos de la comunidad y publicaciones -->
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="contenedor-footer">
            <p>&#169; CosmicCatStudio 2024</p>
        </div>
    </footer>

    <script>
    let imagenComunidadGlobal = ''; // Variable global para almacenar la imagen de la comunidad
    const idArtista = new URLSearchParams(window.location.search).get('id');

    function irAPagina(url) {
        window.location.href = url + `?id=${idArtista}`;
    }
    function irAPagina2(url) {
            window.location.href = url;
        }

    document.addEventListener('DOMContentLoaded', function() {
        // Cargar la comunidad
        fetch(`../php5/comunidad_back.php?id=${idArtista}`)
            .then(response => response.json())
            .then(data => {
                const contenedorComunidad = document.getElementById('comunidad-container');

                if (data.success) {
                    imagenComunidadGlobal = `data:${data.comunidad.tipo_foto};base64,${data.comunidad.foto}`;
                    
                    // Mostrar el título, publicaciones y botón de eliminar
                    contenedorComunidad.innerHTML = `
                        <h2 id="titulo-comunidad">${data.comunidad.nombre}</h2>
                        <button class="boton-eliminar-comunidad" onclick="eliminarComunidad(${data.comunidad.id_comunidad})">Eliminar Comunidad</button>
                        <div class="input-publicacion">
                            <img class="img-artista" src="${imagenComunidadGlobal}" alt="Imagen de la comunidad">
                            <textarea class="input-comentario input-text" id="texto-publicacion" placeholder="Escribe una publicación..."></textarea>
                            <input type="button" class="boton-comentar boton-publi" value="Publicar" onclick="publicar(${data.comunidad.id_comunidad})">
                        </div>
                        <div id="publicaciones"></div>
                    `;
                    cargarPublicaciones(data.comunidad.id_comunidad);
                } else {
                    contenedorComunidad.innerHTML = `
                        <h2>¡Uy! No tienes una comunidad</h2>
                        <button class="boton-crear-comunidad" onclick="window.location.href='crearComunidad.php?id=${idArtista}'">Crear mi comunidad</button>
                    `;
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Función para cargar publicaciones de la comunidad
    function cargarPublicaciones(idComunidad) {
        fetch(`../php5/publicaciones.php?id_comunidad=${idComunidad}`)
            .then(response => response.json())
            .then(data => {
                const publicacionesContainer = document.getElementById('publicaciones');
                publicacionesContainer.innerHTML = '';

                data.publicaciones.forEach(publicacion => {
                    const divPublicacion = document.createElement('div');
                    divPublicacion.className = 'publicacion';
                    divPublicacion.innerHTML = `
                        <div class="publi-artista">
                            <div class="cabecera-publi">
                                <img class="img-cabecera-publi" src="${imagenComunidadGlobal}" alt="Imagen de la comunidad">
                                <p class="autor-publi">${publicacion.autor}</p>
                            </div>
                            <div class="contenido-publi">
                                <p class="texto-publi">${publicacion.texto}</p>
                            </div>
                            <div class="contenedor-ver-todo">
                                <a href="#" onclick="event.preventDefault(); mostrarComentarios(${publicacion.id_publicacion});">
                                    <strong>Ver comentarios</strong> (${publicacion.comentarios.length})
                                </a>
                            </div>
                        </div>
                        <div id="comentarios-${publicacion.id_publicacion}" class="comentarios"></div>
                    `;
                    publicacionesContainer.appendChild(divPublicacion);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Función para publicar una nueva publicación
    function publicar(idComunidad) {
        const texto = document.getElementById('texto-publicacion').value;

        fetch(`../php5/publicar.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_comunidad: idComunidad, texto: texto })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarPublicaciones(idComunidad); // Cargar publicaciones sin perder la imagen
            } else {
                alert('Error al publicar: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Función para mostrar los comentarios de una publicación
    function mostrarComentarios(idPublicacion) {
        fetch(`../php5/comentarios.php?id_publicacion=${idPublicacion}`)
            .then(response => response.json())
            .then(data => {
                const comentariosContainer = document.getElementById(`comentarios-${idPublicacion}`);
                comentariosContainer.innerHTML = '';  // Limpiar comentarios previos

                data.comentarios.forEach(comentario => {
                    const divComentario = document.createElement('div');
                    divComentario.className = 'item-comentario';
                    divComentario.innerHTML = `
                        <div class="cabecera-comentario centrar-cabecera">
                            <img class="comentario-img" src="data:${comentario.avatar_tipo};base64,${comentario.avatar}" alt="Avatar de ${comentario.nombre}">
                            <p class="nombre-comentario-usuario">${comentario.nombre}</p>
                        </div>
                        <div class="comentario-contenido">
                            <p class="texto-comentario">${comentario.texto}</p>
                        </div>
                    `;
                    comentariosContainer.appendChild(divComentario);
                });

                comentariosContainer.style.display = 'block';
            })
            .catch(error => console.error('Error al cargar comentarios:', error));
    }

    // Función para eliminar la comunidad
    function eliminarComunidad(idComunidad) {
        if (confirm("¿Estás seguro de que deseas eliminar esta comunidad? Esta acción no se puede deshacer.")) {
            fetch(`../php5/eliminar_comunidad.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_comunidad: idComunidad })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('La comunidad ha sido eliminada con éxito.');
                    window.location.href = 'profile.php?id=' + idArtista; // Redirigir después de la eliminación
                } else {
                    alert('Error al eliminar la comunidad: ' + data.message);
                }
            })
            .catch(error => console.error('Error al eliminar la comunidad:', error));
        }
    }
</script>

</body>
</html>