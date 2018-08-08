<?php 

$method = $_SERVER['REQUEST_METHOD'];

if( $method == 'POST'){
	echo 'Rolou';
}else{
	echo 'Nem rolou heim';
}

?>