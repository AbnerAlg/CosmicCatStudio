document.getElementById('artista-boton').addEventListener('click', function() {
    // Capturar los valores de los campos
    const correo = document.getElementById('correo').value.trim();
    const password = document.getElementById('password').value;

    // Verificar que los campos no estén vacíos
    if (!correo) {
        alert("Ingresa tu correo");
        return;
    }

    if (!password) {
        alert("Ingresa tu contraseña");
        return;
    }

    // Crear un objeto con los datos a enviar
    const data = {
        correo: correo,
        password: password
    };

    // Enviar los datos al archivo PHP usando fetch
    fetch('../php5/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json()) // Convertir la respuesta a JSON
    .then(data => {
        if (data.error) {
            alert(data.message); // Mostrar el mensaje de error devuelto por el PHP
        } else {
            alert(data.message); // Mensaje de éxito
            
            // Redireccionar según el tipo de usuario (artista u oyente) y pasar el ID
            if (data.tipo === 'artista') {
                window.location.href = `profile.php?id=${data.idartista}`;
            } else if (data.tipo === 'oyente') {
                window.location.href = `listener_profile.php?id=${data.id_oyente}`;
            }
        }
    })
    .catch(error => {
        alert("Hubo un error: " + error.message); // Manejo de errores
    });
});