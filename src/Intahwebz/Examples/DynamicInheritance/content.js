

function loadImagesSuccess(response, textStatus, jqXHR) {
	$("#mainContent").html(response);
}

function loadImages() {

	var params = {};

	params.panel = true;

	$.ajax({
		url: 'TheProblem.php',
		data: params,
	//	dataType: 'json',
		type: 'POST',
		success: loadImagesSuccess,
	});
}


function loadImagesDynamic() {

	var params = {};

	params.panel = true;

	$.ajax({
		url: 'TheSolution.php',
		data: params,
		//	dataType: 'json',
		type: 'POST',
		success: loadImagesSuccess,
	});
}


//uncomment this to see that the Javascript for the page is being loaded on every content refresh
//alert("Javascript file is loaded.");