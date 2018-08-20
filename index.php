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
			
			$ch = curl_init('https://my-php-tester.herokuapp.com/');
			curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json\r\n'
				),
				CURLOPT_POSTFIELDS => json_encode($postdata)
			));
			$request = curl_exec($ch);
			echo $request;
			
			$response = new \stdClass();
			
			$response->fulfillmentText = $id;
			$response->source = 'webhook';
		}
		
		else{
			$response->fulfillmentText = 'ID não recebido';
			$response->source = 'webhook';
		}
		
		echo json_encode($response);
		
	}
	else{
		echo 'Não foi recebido uma requisição do tipo POST';
	}
?>