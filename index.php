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
			$response->fulfillmentText = 'Mesma coisa do Speech';
			$response->source = 'webhook';
		}
		
		echo json_encode($response);
		
		$url = 'https://my-php-tester.herokuapp.com/';
		$data = array('key1' => 'value1', 'key2' => 'value2');
		// use key 'http' even if you send the request to https://...
		$options = array(
		  'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		  ),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		echo json_encode($data);
		var_dump($result);
		
	}else{
		echo 'Nem rolou heim';
	}
?>