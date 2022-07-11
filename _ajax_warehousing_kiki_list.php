<?php

require_once('config/config.php');

$app = new \MyApp\Warehousing_kiki_list();

if( $_SERVER["REQUEST_METHOD"] === "POST"){
	try{
		$res = $app->ajax_postprocess();

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
