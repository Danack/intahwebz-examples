

function loadImagesSuccess(response, textStatus, jqXHR) {
	$("#mainContent").html(response);
}

function loadImages() {

	var params = {};

	params.panel = true;

	$.ajax({
		url: '/TheProblem.php',
		data: params,
	//	dataType: 'json',
		type: 'GET',
		success: loadImagesSuccess,
	});
}




function loadImagesDynamic() {

	var params = {};

	params.panel = true;

	$.ajax({
		url: '/TheSolution.php',
		data: params,
		//	dataType: 'json',
		type: 'GET',
		success: loadImagesSuccess,
	});
}

