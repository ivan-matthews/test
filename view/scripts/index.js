$(document).ready(function () {
	$( "form[name=\"getNumber\"]" ).submit(function( event ) {
		event.preventDefault();
		getNumber(this);
	});
});

function getNumber(form){
	let formObject = $(form);
	let number = $('input#text',formObject).val();

	$.ajax({
		url: '/foobar/' + number,
		method: 'GET',
		data: $(form).serialize(),
		dataType: 'JSON',
		success: function(response){
			console.log(response);

			let result_block = $('.result-block');
			let result = $('#result', result_block);
			let time = $('#time', result_block);
			result_block.removeClass('d-none');
			result.text(response.result);
			time.text(response.datetime);
		},
		error: function(error){
			alert('Request failed!');
		}
	});
}