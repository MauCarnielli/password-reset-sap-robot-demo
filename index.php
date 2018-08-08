<?php 

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$id = $json->queryResult->parameters->id;
	
	$response = new \stdClass();
	
	if($id != NULL){
		$response->speech = $id;
		$response->displayText = $id;
		$response->source = 'webhook';
	}else{
		$response->speech = 'Nao tem ID nisso ai';
		$response->displayText = 'Mesma coisa do Speech';
		$response->source = 'webhook';
	}
	
	echo json_encode($response);
	
}else{
	echo 'Nem rolou heim';
}

?>