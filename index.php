<?php
	$method = $_SERVER['REQUEST_METHOD']; //Verifica qual o m�todo da requisi��o

	if($method == 'POST'){ 
		$requestBody = file_get_contents('php://input'); //Recebe o conte�do em JSON da requisi��o
		$json = json_decode($requestBody); //Decodifica de JSON para texto	
		$id = $json->queryResult->parameters->id; //Extrai apenas o ID, seguindo a estrutura de arrays que est� no texto.
		
		if($id != NULL){
			$orchestratorData = json_encode(array(
				'startInfo' => array(
					"ReleaseKey": "Insira a chave aqui",
					"Strategy": "All",
					"RobotIds": [],
					"NoOfRobots": 0
				)
			)); // Este � o conte�do do JSON da nova requisi��o que vai ser mandada para o Orchestrator para iniciar o Job
				// Refer�ncia: https://orchestrator.uipath.com/v2018.2/reference#section-starting-a-job
			
			$context = stream_context_create(array( //Este � o contexto, ou seja, toda a informa��o que vai ser passada pela requisi��o
				'http'=>array(
					'method' => 'POST', //Neste caso, mandamos uma requisi��o do tipo POST
					'header' => 'Content-Type: application/json\r\n', //Qual o conte�do que est� sendo mandado, no caso um JSON
					'content' => $orchestratorData //O conte�do
				)
			)); 
			
			$req = file_get_contents('url_do_orchestrator', FALSE, $context); //Envia a requisi��o para o link e armazena na vari�vel a resposta.
			
			$responseDialog = array( //Esta vari�vel � a resposta final, ou seja, a que vai para o DialogFlow. A resposta que o usu�rio vai obter ap�s o processo.
				'fulfillmentText' => 'ID Recebido � -> '.$id, //Aqui vai a mensagem que ir� aparecer na conversa com o Chatbot
				'source' => 'webhook'
			);
		}
		
		else{
			$responseDialog = array( //Caso o ID n�o seja alcan�ado.
				'fulfillmentText' => 'ID n�o recebido',
				'source' => 'webhook'
			); 
		}
		
		echo json_encode($responseDialog); //Codifica para JSON e manda para o DialogFlow.
		
	}
	else{
		echo 'N�o foi recebido uma requisi��o do tipo POST';
	}
?>