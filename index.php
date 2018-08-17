<?php
	$method = $_SERVER['REQUEST_METHOD'];

	if($method == 'POST'){
		$requestBody = file_get_contents('php://input');
		$json = json_decode($requestBody);
		$id = $json->queryResult->parameters->id;
		
		if($id != NULL){
			$url = 'https://my-php-tester.herokuapp.com/';
			$data = array('id' => $id, 'source' => 'password-reset-sap-robot-demo');
			$options = array(
			  'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			  ),
			);
			$context  = stream_context_create($options);
			
			
			$result = file_get_contents($url, true, $context);
			echo json_encode($result);
			var_dump($result);
			
			$response = new \stdClass();
			
			$response->speech = $id;
			$response->displayText = $id;
			$response->source = 'webhook';
		}
		else if($method == 'GET'){
			$reponse->speech = "Oi Leandro";
			$reponse->status = "Deu certo!";
		}
		else{
			$response->speech = 'Nao tem ID nisso ai';
			$response->fulfillmentText = 'Mesma coisa do Speech';
			$response->source = 'webhook';
		}
		
		echo json_encode($response);
		
	}else{
		echo 'Nem rolou heim';
	}
?>