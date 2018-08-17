<?php
	$method = $_SERVER['REQUEST_METHOD'];

	if($method == 'POST'){
		$requestBody = file_get_contents('php://input');
		$json = json_decode($requestBody);
		$id = $json->queryResult->parameters->id;
		
		
		$url = 'https://my-php-tester.herokuapp.com/';
		$data = array('id' => $id, 'source' => 'password-reset-sap-robot-demo');
		$options = array(
		  'http' => array(
			'method'  => 'POST',
			'content' => http_build_query($data),
		  ),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		
		$response = new \stdClass();
		
		if($id != NULL){
			$response->speech = $id;
			$response->displayText = $id;
			$response->source = 'webhook';
		}else{
			$response->speech = 'Nao tem ID nisso ai';
			$response->fulfillmentText = 'Mesma coisa do Speech';
			$response->source = 'webhook';
		}
		
	
		echo json_encode($result);
		echo json_encode($response);
		
	}else{
		echo 'Nem rolou heim';
	}
?>
