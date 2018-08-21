<?php
	$method = $_SERVER['REQUEST_METHOD']; //Verifica qual o m�todo da requisi��o

	if($method == 'POST'){ 
		$requestBody = file_get_contents('php://input'); //Recebe o conte�do em JSON da requisi��o
		$json = json_decode($requestBody); //Decodifica de JSON para texto	
		$id = $json->queryResult->parameters->id; //Extrai apenas o ID, seguindo a estrutura de arrays que est� no texto.
		
		if($id != NULL){
			
			$orchestratorData = json_encode(array(
				'id' => $id,
				'source' => 'password-reset-sap-robot-demo'
			)); // Este � o conte�do do JSON da nova requisi��o que vai ser mandada para o Orchestrator
			
			$context = stream_context_create(array(
				'http'=>array(
					'method' => 'POST', //Neste caso, mandamos uma requisi��o do tipo POST
					'header' => 'Content-Type: application/json\r\n', //Qual o conte�do que est� sendo mandado, no caso um JSON
					'content' => $orchestratorData //O conte�do
				)
			)); //Este � o contexto, ou seja, toda a informa��o que vai ser passada pela requisi��o
			
			$req = file_get_contents('https://my-php-tester.herokuapp.com/', FALSE, $context); //Envia a requisi��o para o link e armazena na vari�vel a resposta.
			
			$response = array(
				'fulfillmentText' => $id, //Aqui vai a mensagem que ir� aparecer na conversa com o Chatbot
				'source' => 'webhook'
			);//Esta vari�vel � a resposta final, ou seja, a que vai para o DialogFlow. A resposta que o usu�rio vai obter ap�s o processo.
		}
		
		else{
			$response = array(
				'fulfillmentText' => 'ID n�o recebido',
				'source' => 'webhook'
			); //Caso o ID n�o seja alcan�ado.
		}
		
		echo json_encode($response); //Codifica para JSON e manda para o DialogFlow.
		
	}
	else{
		echo 'N�o foi recebido uma requisi��o do tipo POST';
	}
?>