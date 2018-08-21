<?php
	$method = $_SERVER['REQUEST_METHOD']; //Verifica qual o método da requisição
	if($method == 'POST'){ 
		$requestBody = file_get_contents('php://input'); //Recebe o conteúdo em JSON da requisição
		$json = json_decode($requestBody); //Decodifica de JSON para texto	
		$id = $json->result->parameters->id; //Extrai apenas o ID, seguindo a estrutura de arrays que está no texto.
		
		if($id != NULL){
			
			$jobData = array( // Conteúdo do POST a ser mandado para o Orchestrator, afim de começar um Job
				'startInfo'=>array(
					'ReleaseKey' => 'Inserir chave do processo aqui',
					'Strategy' => 'All',
					'RobotIds' => '[]',
					'NoOfRobots' => 0
				)
			); // Referência -> https://orchestrator.uipath.com/v2018.2/reference#section-starting-a-job
				
			
			$context = stream_context_create(array( //Este é o contexto, ou seja, toda a informação que vai ser passada pela requisição
				'http'=>array(
					'method' => 'POST', //Neste caso, mandamos uma requisição do tipo POST
					'header' => 'Content-Type: application/json\r\n', //Qual o conteúdo que está sendo mandado, no caso um JSON
					'content' => json_encode($jobData) //O conteúdo, codificado em JSON
				)
			)); 
			
			$req = file_get_contents('url_do_orchestrator/odata/Jobs/UiPath.Server.Configuration.OData.StartJobs', FALSE, $context); //Envia a requisição para o link e armazena na variável a resposta.
			
			$responseDialog = array( //Esta variável é a resposta final, ou seja, a que vai para o DialogFlow. A resposta que o usuário vai obter após o processo.
				'displayText' => 'ID Recebido é -> '.$id. '. Requisição completa.', //Aqui vai a mensagem que irá aparecer na conversa com o Chatbot
				'source' => 'webhook'
			);
		}
		
		else{
			$responseDialog = array( //Caso o ID não seja alcançado.
				'displayText' => 'ID não recebido',
				'source' => 'webhook'
			); 
		}
		
		//echo $requestBody;
		echo json_encode($responseDialog); //Codifica para JSON e manda para o DialogFlow.
		
	}
	else{
		echo 'Não foi recebido uma requisição do tipo POST';
	}
?>