function mostrarPrevia(event) {
    var leerImagen = new FileReader();
    leerImagen.onload = function() {
        var imgPrevia = document.getElementById('imagen-previa');
        imgPrevia.src = leerImagen.result;
    };
    leerImagen.readAsDataURL(event.target.files[0]);
}
    

function mostrarPreviaBanner(event) {
    var leerImagen = new FileReader();
    leerImagen.onload = function() {
        var imgPrevia = document.getElementById('imagen-previa-banner');
        imgPrevia.src = leerImagen.result;
    };
    leerImagen.readAsDataURL(event.target.files[0]);
}