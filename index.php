<?php 

$method = $_SERVER['REQUEST_METHOD'];

if( $method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$id = $json->queryResult->parameters->id;
	
	$response = new \stdClass();
	$response->speech = $id;
	$response->displayText = $id;
	$response->source = 'Gzus';
	echo json_encode($response);
	
}else{
	echo 'Nem rolou heim';
}

?>