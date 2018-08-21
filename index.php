<?php
	$method = $_SERVER['REQUEST_METHOD']; //Verifica qual o mщtodo da requisiчуo

	if($method == 'POST'){ 
		$requestBody = file_get_contents('php://input'); //Recebe o conteњdo em JSON da requisiчуo
		$json = json_decode($requestBody); //Decodifica de JSON para texto	
		$id = $json->queryResult->parameters->id; //Extrai apenas o ID, seguindo a estrutura de arrays que estс no texto.
		
		if($id != NULL){
			$orchestratorData = json_encode(array(
				'startInfo' => array(
					"ReleaseKey": "Insira a chave aqui",
					"Strategy": "All",
					"RobotIds": [],
					"NoOfRobots": 0
				)
			)); // Este щ o conteњdo do JSON da nova requisiчуo que vai ser mandada para o Orchestrator para iniciar o Job
				// Referъncia: https://orchestrator.uipath.com/v2018.2/reference#section-starting-a-job
			
			$context = stream_context_create(array( //Este щ o contexto, ou seja, toda a informaчуo que vai ser passada pela requisiчуo
				'http'=>array(
					'method' => 'POST', //Neste caso, mandamos uma requisiчуo do tipo POST
					'header' => 'Content-Type: application/json\r\n', //Qual o conteњdo que estс sendo mandado, no caso um JSON
					'content' => $orchestratorData //O conteњdo
				)
			)); 
			
			$req = file_get_contents('url_do_orchestrator', FALSE, $context); //Envia a requisiчуo para o link e armazena na variсvel a resposta.
			
			$responseDialog = array( //Esta variсvel щ a resposta final, ou seja, a que vai para o DialogFlow. A resposta que o usuсrio vai obter apѓs o processo.
				'fulfillmentText' => 'ID Recebido щ -> '.$id, //Aqui vai a mensagem que irс aparecer na conversa com o Chatbot
				'source' => 'webhook'
			);
		}
		
		else{
			$responseDialog = array( //Caso o ID nуo seja alcanчado.
				'fulfillmentText' => 'ID nуo recebido',
				'source' => 'webhook'
			); 
		}
		
		echo json_encode($responseDialog); //Codifica para JSON e manda para o DialogFlow.
		
	}
	else{
		echo 'Nуo foi recebido uma requisiчуo do tipo POST';
	}
?>