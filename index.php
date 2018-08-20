<?php

	$method = $_SERVER['REQUEST_METHOD'];

	if($method == 'POST'){
		$requestBody = file_get_contents('php://input');
		$json = json_decode($requestBody);
		$id = $json->queryResult->parameters->id;
		
		if($id != NULL){
			
			$postdata = json_encode(array(
				'id' => $id,
				'source' => 'password-reset-sap-robot-demo'
			));
			
			$context = stream_context_create(array(
				'http'=>array(
					'method' => 'POST',
					'header' => 'Content-Type: application/json\r\n',
					'content' => $postdata
				)
			));
			$req = file_get_contents('https://my-php-tester.herokuapp.com/', FALSE, $context);
				
			
			$response = new \stdClass();
			
			$response->fulfillmentText = $id;
			$response->source = 'webhook';
		}
		
		else{
			$response->fulfillmentText = 'ID não recebido';
			$response->source = 'webhook';
		}
		
		//echo json_encode($response);
		
	}
	else{
		echo 'Não foi recebido uma requisição do tipo POST';
	}
?>