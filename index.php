<?php

	$method = $_SERVER['REQUEST_METHOD'];

	if($method == 'POST'){
		$requestBody = file_get_contents('php://input');
		$json = json_decode($requestBody);
		$id = $json->queryResult->parameters->id;
		
		if($id != NULL){
			
			$postdata = array(
				array(
					'id' => $id,
					'source' => 'password-reset-sap-robot-demo'
				)
			);
			
			$opts = array('http'=>
				array(
					'method' => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => json_encode($postdata);
				)
			);
			$context = stream_context_create($opts);
			$result = file_get_contents('https://my-php-tester.herokuapp.com/', false, $context);
			echo $result;
			
			$response = new \stdClass();
			
			$response->fulfillmentText = $id;
			$response->source = 'webhook';
		}
		
		else{
			$response->speech = 'Nao tem ID nisso ai';
			$response->fulfillmentText = 'Mesma coisa do Speech';
			$response->source = 'webhook';
		}
		
		echo json_encode($response);
		
	}
	else{
		echo 'Não foi recebido uma requisição do tipo POST';
	}
?>