// Función para mostrar el ícono de la flecha cuando se hace scroll
window.onscroll = function() {
    if (window.scrollY > 200) {
        document.body.classList.add('scrolled');
    } else {
        document.body.classList.remove('scrolled');
    }
};

// Función para subir al inicio cuando se haga clic en la flecha
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}