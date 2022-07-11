<?php

require_once('config/config.php');

$app = new \MyApp\Returned();

if( $_SERVER["REQUEST_METHOD"] === "POST"){
	try{
		switch($_POST['mode']){
			case 'search':
				$res = $app->search();
				break;
			case 'inputDb':
				$res = $app->inputDb();
				break;
		}
		if($res){
			header('Content-Type: application/json');
			echo json_encode($res);
			exit;
		}
	}catch(Exception $e){
		echo $e->getMessage();
		exit;
	}

}
