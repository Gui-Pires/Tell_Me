$(document).ready(function() {
	$('.carousel').carousel();
	$('.modal').modal();
	$('.fixed-action-btn').floatingActionButton();
	$('.slider').slider({
		indicators: false,
		height: 600,
		interval: 5000
	});
    $('.dropdown-trigger').dropdown();
    $('.parallax').parallax();
    $('.tooltipped').tooltip();
    $('.collapsible').collapsible();
    $('.sidenav').sidenav();
    $('.carousel.carousel-slider').carousel({
	    fullWidth: true,
	    indicators: true
  	});
    M.updateTextFields();
  	$('input#titulo, textarea#descricao').characterCounter();
});