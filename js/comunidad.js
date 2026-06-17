function mostrarRecuadro() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('recuadro-comentarios').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function cerrarModal(event) {
    if (event.target === document.getElementById('overlay')) {
        ocultarRecuadro();
    }
}

function ocultarRecuadro() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('recuadro-comentarios').style.display = 'none';
    document.body.style.overflow = 'auto';
}
// Variable global para almacenar las comunidades
let comunidadesGlobal = [];
let avatarOyente = '';
let avatarTipoOyente = '';
document.addEventListener("DOMContentLoaded", function() {
    const id_oyente = new URLSearchParams(window.location.search).get('id');

    // Obtener datos del oyente (avatar y tipo de avatar)
    fetch(`../php5/obtener_oyente.php?id=${id_oyente}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                avatarOyente = data.avatar;
                avatarTipoOyente = data.avatar_tipo;
            } else {
                console.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error al cargar el oyente:', error);
        });

    // Obtener las comunidades del oyente
    fetch(`../php5/comunidad-listener.php?id=${id_oyente}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.comunidades && data.comunidades.length > 0) {
                    comunidadesGlobal = data.comunidades; // Guardar en variable global
                    mostrarComunidades(data.comunidades);
                } else {
                    mostrarMensajeSinComunidades();
                }
            } else {
                console.error(data.message);
                mostrarMensajeSinComunidades();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function mostrarMensajeSinComunidades() {
    document.querySelector('.contenedor-main').innerHTML = `
        <div class="mensaje-no-comunidad">
            <p>Parece que todavía no perteneces a una comunidad.</p>
            <button onclick="verComunidades()">Ver comunidades</button>
        </div>
    `;
}

function mostrarComunidades(comunidades) {
    const listaComunidades = document.querySelector('.lista-comunidades');
    listaComunidades.innerHTML = ''; // Limpiar antes de agregar nuevas comunidades

    comunidades.forEach(comunidad => {
        const comunidadItem = document.createElement('div');
        comunidadItem.classList.add('comunidad-item');
        comunidadItem.innerHTML = `
            <a href="#" class="sin-mod" onclick="event.preventDefault(); cambiarContenidoComunidad(${comunidad.id_comunidad})">
                <div class="orden-item">
                    <img src="data:${comunidad.tipo_foto};base64,${comunidad.foto}" class="item-comunidad-img" alt="">
                    <p class="item-titulo">${comunidad.nombre}</p>
                </div>
            </a>
        `;
        listaComunidades.appendChild(comunidadItem);
    });
}

function cambiarContenidoComunidad(id_comunidad) {
    const comunidad = comunidadesGlobal.find(com => com.id_comunidad === id_comunidad);
    if (!comunidad) return;

    document.getElementById('titulo-comunidad').textContent = comunidad.nombre;

    // Mostrar el botón de salida y almacenar el id_comunidad actual
    const botonSalir = document.getElementById('boton-salir-comunidad');
    botonSalir.style.display = 'inline-block'; 
    botonSalir.dataset.idComunidad = id_comunidad; 

    const publicacionesContainer = document.getElementById('publicaciones-container');
    publicacionesContainer.innerHTML = comunidad.publicaciones.map(publicacion => `
        <div class="publi-artista">
            <div class="cabecera-publi">
                <img src="data:${comunidad.tipo_foto};base64,${comunidad.foto}" class="img-cabecera-publi" alt="">
                <p class="autor-publi" onclick="redirigirAlPerfil(${comunidad.id_artista})">${comunidad.nombre}</p>
            </div>
            <div class="contenido-publi">
                <p>${publicacion.texto}</p>
            </div>
            <div class="contenedor-ver-todo">
                <a class="sin-mod" href="#" onclick="event.preventDefault(); mostrarComentarios(${publicacion.id_publicacion}, ${comunidad.id_comunidad})">
                    <strong>Ver comentarios</strong>
                </a>
            </div>
            <div class="comentar">
                <div class="comentario">
                    <div class="cabecera-comentario">
                        <img class="comentario-img" src="data:${avatarTipoOyente};base64,${avatarOyente}" alt="Tu Avatar">
                        <input class="input-comentario" type="text" placeholder="Escribe un comentario..." id="comentario-${publicacion.id_publicacion}" />
                        <button class="boton-comentar" onclick="enviarComentario(${publicacion.id_publicacion}, ${id_comunidad})">Comentar</button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function salirDeComunidad() {
    const id_oyente = new URLSearchParams(window.location.search).get('id');
    const id_comunidad = document.getElementById('boton-salir-comunidad').dataset.idComunidad;

    fetch('../php5/salir_comunidad.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_oyente, id_comunidad })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Has salido de la comunidad exitosamente.');
            location.reload(); // Recargar la página para actualizar la lista de comunidades
        } else {
            alert('Error al salir de la comunidad: ' + data.message);
        }
    })
    .catch(error => console.error('Error al salir de la comunidad:', error));
}

function enviarComentario(id_publicacion, id_comunidad) {
    const comentarioInput = document.getElementById(`comentario-${id_publicacion}`);
    const comentarioTexto = comentarioInput.value.trim();

    if (!comentarioTexto) {
        alert("Por favor, escribe un comentario antes de enviar.");
        return;
    }

    const id_oyente = new URLSearchParams(window.location.search).get('id');

    // Realizar el fetch para enviar el comentario a la base de datos
    fetch(`../php5/agregar_comentario.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_oyente,
            id_publicacion,
            texto: comentarioTexto
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Limpiar el campo de comentario después de enviar
            comentarioInput.value = '';

            // Construir el nuevo comentario HTML
            const nuevoComentarioHTML = `
                <div class="item-comentario">
                    <div class="cabecera-comentario centrar-cabecera">
                        <img class="comentario-img" src="data:${avatarTipoOyente};base64,${avatarOyente}" alt="Tu Avatar">
                        <p class="nombre-comentario-usuario">Tú</p>
                    </div>
                    <div class="comentario-contenido">
                        <p class="texto-comentario">${comentarioTexto}</p>
                    </div>
                </div>
            `;

            // Añadir al contenedor de comentarios del modal
            const comentariosContainer = document.querySelector('.lista-comentarios-contenedor');
            if (comentariosContainer) {
                comentariosContainer.insertAdjacentHTML('afterbegin', nuevoComentarioHTML);
            }

            // Añadir también en la lista principal de publicaciones
            const publicacionComentariosContainer = document.querySelector(`#publicacion-${id_publicacion} .comentarios`);
            if (publicacionComentariosContainer) {
                publicacionComentariosContainer.insertAdjacentHTML('afterbegin', nuevoComentarioHTML);
            }

            // Actualizar `comunidadesGlobal` con el nuevo comentario
            const comunidad = comunidadesGlobal.find(com => com.id_comunidad === id_comunidad);
            const publicacion = comunidad?.publicaciones.find(pub => pub.id_publicacion === id_publicacion);
            if (publicacion) {
                publicacion.comentarios.unshift({
                    nombre: "Tú",
                    avatar: avatarOyente,
                    avatar_tipo: avatarTipoOyente,
                    texto: comentarioTexto
                });
            }

        } else {
            alert('Error al enviar el comentario: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al enviar el comentario.');
    });
} 

function verComunidades() {
    const id_oyente = new URLSearchParams(window.location.search).get('id');
    window.location.href = `elegir_comunidad.php?id=${id_oyente}`;
}

function mostrarComentarios(id_publicacion, id_comunidad) {
    const comunidad = comunidadesGlobal.find(com => com.id_comunidad === id_comunidad);
    const publicacion = comunidad?.publicaciones.find(pub => pub.id_publicacion === id_publicacion);
    if (!publicacion) return;

    const comentariosContainer = document.querySelector('.lista-comentarios-contenedor');
    comentariosContainer.innerHTML = publicacion.comentarios.map(comentario => `
        <div class="item-comentario">
            <div class="cabecera-comentario centrar-cabecera">
                <img class="comentario-img" src="data:${comentario.avatar_tipo};base64,${comentario.avatar}" alt="Avatar de ${comentario.nombre}">
                <p class="nombre-comentario-usuario">${comentario.nombre}</p>
            </div>
            <div class="comentario-contenido">
                <p class="texto-comentario">${comentario.texto}</p>
            </div>
        </div>
    `).join('');
    
    mostrarRecuadro();
}

function redirigirAlPerfil(id_artista) {
    const id_oyente = new URLSearchParams(window.location.search).get('id');

    // Realizar el fetch para incrementar la visita
    fetch(`../php5/sumar_visita.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_oyente, id_artista })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redireccionar al perfil del artista con los parámetros en la URL
            window.location.href = `../html/profile_view.php?id=${id_oyente}&idart=${id_artista}`;
        } else {
            console.error('Error al sumar la visita:', data.message);
        }
    })
    .catch(error => {
        console.error('Error al sumar la visita:', error);
    });
}
