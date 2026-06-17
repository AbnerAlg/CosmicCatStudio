// VARIABLES GLOBALES
  
var web = $(document);
var navicon = $(".menu-principal>.icon");
var trigger = $(".trigger");
var menu_link = $(".menu-principal .enlace");
var seccion = $("section")  
var menu_contenedor = $('.encabezado');
var limites_menu = menu_contenedor.offset();
var logo = $(".menu .logo img");

// document ready

web.ready(function(){
  
var anclas = $('a[href*="#"]:not(.mas-info)');
var website = $('html, body');

// prevenir el salto de pagina en enlaces trigger
trigger.click(function(event) {
  event.preventDefault();
});  


// prevenir el salto de pagina en enlaces trigger
function anclando_A () {
  anclas.on("click", scroll_A);  
};

function scroll_A (){
  event.preventDefault();
  var _href = $(this).attr('href');
  website.animate({ scrollTop : $( _href ).offset().top-100 }, 'slow');
}﻿;

anclando_A();

// Cuando scroll logo encabezado cambia

$(window).on('scroll', function() {
  if($(window).scrollTop() > limites_menu.top) {
    menu_contenedor.addClass('logo-landing');
    logo.attr("src","http://eduholding.gutierrezedgar.com/img/logo-eduholding-movil.png");
  } else {
    menu_contenedor.removeClass('logo-landing');
    logo.attr("src","http://eduholding.gutierrezedgar.com/img/logo-eduholding-full.png");
  }    
});

}); 