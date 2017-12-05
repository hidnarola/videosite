$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
	items:4,
	navigation:true,
})
$('document').ready(function(){
	$('.btn_sign_in, .btn_header_login').click(function(){
		$('.sign-up').addClass('hide');
		$('.sign-in').removeClass('hide');
	});
	$('.btn_sign_up, .btn_header_register').click(function(){
		$('.sign-in').addClass('hide');
		$('.sign-up').removeClass('hide');
	});
});

$(function() {
	$(document).on('change', ':file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});
	$(document).ready( function() {
		$(':file').on('fileselect', function(event, numFiles, label) {
			var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
			if( input.length ) {
				input.val(log);
			} else {
				// if( log ) alert(log);
				$('.input-file > input[type=text]').val(log);
				console.log(log);
			}
		});
	});
});