<?php

require_once('config/config.php');

$app = new \MyApp\Proceeds();

if( $_SERVER["REQUEST_METHOD"] === "POST"){
	try{
		switch($_POST['mode']){
			case 'search':
				$res = $app->search();
				break;
			case 'choice':
				$res = $app->choice();
				break;
			case 'dbInsert':
				$res = $app->dbInsert();
				break;
			case 'deleteSubRow':
				$res = $app->deleteSubRow();
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
