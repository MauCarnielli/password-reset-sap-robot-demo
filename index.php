<?php 

function recebeJson{
	
	$method = $_SERVER['REQUEST_METHOD'];

	if($method == 'POST'){
		enviaPost();
	}else{
		echo "huuummmm....."
	}	
}

function enviaPost{
	$url = 'http://server.com/path';
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
	var_dump($result);
}

recebeJson();

?>