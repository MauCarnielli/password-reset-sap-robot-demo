<?php 

$method = $_SERVER['REQUEST_METHOD'];

if( $method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$id = $json->queryResult->parameters->id;
	echo $id;
	
}else{
	echo 'Nem rolou heim';
}

?>