// Validaciones de formulario en JavaScript
const form = document.getElementById('loginForm');
const emailField = document.getElementById('email');
const passwordField = document.getElementById('password');
const emailError = document.getElementById('emailError');
const passwordError = document.getElementById('passwordError');

form.addEventListener('submit', function(event) {
    let valid = true; // Asumimos que el formulario es válido

    // Validar el correo
    const email = emailField.value;
    if (!validateEmail(email)) {
        emailError.style.display = 'block'; // Muestra el mensaje de error
        valid = false;
    } else {
        emailError.style.display = 'none'; // Oculta el mensaje de error
    }

    // Validar la contraseña
    const password = passwordField.value;
    if (password.length < 8) {
        passwordError.style.display = 'block'; // Muestra el mensaje de error
        valid = false;
    } else {
        passwordError.style.display = 'none'; // Oculta el mensaje de error
    }

    // Si alguna validación falla, evitar que el formulario se envíe
    if (!valid) {
        event.preventDefault();
    }
});

// Función para validar el formato del correo electrónico
function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar correo
    return emailPattern.test(email);
}