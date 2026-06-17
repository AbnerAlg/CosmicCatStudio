/* ------------------------------------ Click on login and Sign Up to  changue and view the effect
---------------------------------------
*/

const time_to_show_login = 400;
const time_to_hidden_login = 200;

function change_to_login() {
document.querySelector('.cont_forms').className = "cont_forms cont_forms_active_login";  
document.querySelector('.cont_form_login').style.display = "block";
document.querySelector('.cont_form_sign_up').style.opacity = "0";               

setTimeout(function(){  document.querySelector('.cont_form_login').style.opacity = "1"; },time_to_show_login);  
  
setTimeout(function(){    
document.querySelector('.cont_form_sign_up').style.display = "none";
},time_to_hidden_login);  
  }

  const time_to_show_sign_up = 100;
  const time_to_hidden_sign_up = 400;

function change_to_sign_up(at) {
  document.querySelector('.cont_forms').className = "cont_forms cont_forms_active_sign_up";
  document.querySelector('.cont_form_sign_up').style.display = "block";
document.querySelector('.cont_form_login').style.opacity = "0";
  
setTimeout(function(){  document.querySelector('.cont_form_sign_up').style.opacity = "1";
},time_to_show_sign_up);  

setTimeout(function(){   document.querySelector('.cont_form_login').style.display = "none";
},time_to_hidden_sign_up);  


}    

const time_to_hidden_all = 500;

function hidden_login_and_sign_up() {

document.querySelector('.cont_forms').className = "cont_forms";  
document.querySelector('.cont_form_sign_up').style.opacity = "0";               
document.querySelector('.cont_form_login').style.opacity = "0"; 

setTimeout(function(){
document.querySelector('.cont_form_sign_up').style.display = "none";
document.querySelector('.cont_form_login').style.display = "none";
},time_to_hidden_all);  
  
  }

  document.getElementById('overlay').addEventListener('click', function(event) {
    // Verifica si el clic fue fuera del contenido del overlay
    if (event.target === this) {
        this.style.display = 'none'; // Cierra el overlay
    }
});

document.getElementById('crear_btn').addEventListener('click', function() {
    // Capturar los valores de los campos
    const correo = document.getElementById('correo').value;
    const nombre = document.getElementById('nombre').value;
    const edad = document.getElementById('edad').value;
    const contrasena = document.getElementById('contrasena').value;
    const confirmar_contrasena = document.getElementById('confirmar_contrasena').value;

    // Verificar que las contraseñas coincidan
    if (contrasena !== confirmar_contrasena) {
        alert("Las contraseñas no coinciden.");
        return;
    }

    if (!correo) {
        alert("Por favor, ingresa tu correo.");
        return;
    }
    if (!nombre) {
        alert("Por favor, ingresa tu nombre.");
        return;
    }
    if (!edad) {
        alert("Por favor, ingresa tu edad.");
        return;
    }
    if (!contrasena) {
        alert("Por favor, ingresa una contraseña.");
        return;
    }
    if (!confirmar_contrasena) {
        alert("Por favor, confirma tu contraseña.");
        return;
    }

    console.log(correo);
    console.log(nombre);
    console.log(edad);
    console.log(contrasena);
    console.log(confirmar_contrasena);


    // Crear un objeto con los datos a enviar
    const data = {
        correo: correo,
        nombre: nombre,
        edad: edad,
        contrasena: contrasena,
        confirmar_contrasena: confirmar_contrasena
    };
    console.log(data);

    // Mostrar el overlay
    document.getElementById('overlay').style.display = 'flex'; // Cambiamos a 'flex' para centrar el contenido

    // Enviar los datos al archivo PHP usando fetch
    fetch('../php5/crearCuenta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log(response);
        return response.json(); // Convertir la respuesta a JSON
    })
    .then(data => {
        if (data.error) {
            // Si hay un error, mostrar el mensaje de error
            document.getElementById('overlay-message').innerText = data.message;
        } else {
            // Mensaje de éxito
            document.getElementById('overlay-message').innerText = data.message;
            setTimeout(() => {
                window.location.href = 'webPagelogin.php';
            }, 5000); // 5000 milisegundos = 5 segundos
        }
    })
    .catch(error => {
        console.error('Error:', error); // Muestra el error en la consola
        document.getElementById('overlay-message').innerText = "Hubo un error al agregar los datos."; // Mensaje de error
    });
})

document.getElementById('artista-boton').addEventListener('click', function() {
    // Capturar los valores de los campos
    const correo = document.getElementById('artista-correo').value;
    const nombre = document.getElementById('artista-nombre').value;
    const edad = document.getElementById('artista-edad').value;
    const nom_art =document.getElementById('artista-artistico').value;
    const nacionalidad = document.getElementById('artista-nacionalidad').value;
    const contrasena = document.getElementById('artista-contrasena').value;
    const confirmar_contrasena = document.getElementById('artista-contrasena-confirmar').value;
    
    // Verificar que las contraseñas coincidan
    if (contrasena !== confirmar_contrasena) {
        alert("Las contraseñas no coinciden.");
        return;
    }
    
    if(!nom_art){
        alert("Ingresa tu nombre artistico");
        return;
    }

    if(!nacionalidad){
        alert("Ingresa tu nacionalidad");
        return;
    }

    if (!correo) {
        alert("Por favor, ingresa tu correo.");
        return;
    }
    if (!nombre) {
        alert("Por favor, ingresa tu nombre.");
        return;
    }
    if (!edad) {
        alert("Por favor, ingresa tu edad.");
        return;
    }
    if (!contrasena) {
        alert("Por favor, ingresa una contraseña.");
        return;
    }
    if (!confirmar_contrasena) {
        alert("Por favor, confirma tu contraseña.");
        return;
    }




    // Crear un objeto con los datos a enviar
    const data = {
        correo: correo,
        nombre: nombre,
        edad: edad,
        nom_art: nom_art,
        nacionalidad:nacionalidad,
        contrasena: contrasena,
        confirmar_contrasena: confirmar_contrasena
    };
    console.log(data);

    // Mostrar el overlay
    document.getElementById('overlay').style.display = 'flex'; // Cambiamos a 'flex' para centrar el contenido

    // Enviar los datos al archivo PHP usando fetch
    fetch('../php5/crearCuentaArtista.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log(response);
        return response.json(); // Convertir la respuesta a JSON
    })
    .then(data => {
        if (data.error) {
            // Si hay un error, mostrar el mensaje de error
            document.getElementById('overlay-message').innerText = data.message;
        } else {
            // Mensaje de éxito
            document.getElementById('overlay-message').innerText = data.message;
            setTimeout(() => {
                window.location.href = 'webPagelogin.php';
            }, 5000); // 5000 milisegundos = 5 segundos
        }
    })
    .catch(error => {
        console.error('Error:', error); // Muestra el error en la consola
        document.getElementById('overlay-message').innerText = "Hubo un error al agregar los datos."; // Mensaje de error
    });
})


