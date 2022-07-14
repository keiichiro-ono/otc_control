<?php

require_once('config/config.php');

$app = new \MyApp\Correct_otc();
$app2 = new \MyApp\Sale();
$app3 = new \MyApp\Warehousing();
$app4 = new \MyApp\Inventory();
$app5 = new \MyApp\Setting();
$app6 = new \MyApp\Inventory_table_input();

if($_SERVER['REQUEST_METHOD']==="POST"){
  switch($_POST["url"]){
    case "correct_otc":
      echo $app->delete_img($_POST['id']);
      break;
    case "sale":
      switch($_POST["type"]){
        case "check_id":
          echo $app2->mg_id() + 1;
          break;
        case "inputDb":
          $app2->inputDb();
          break;
        case "searchItem":
          header('Content-Type: application/json');
          echo json_encode($app2->ajax_process());
          break;
      }
    case "warehousing":
      switch($_POST["type"]){
        case "searchItemW":
          header('Content-Type: application/json');
          echo json_encode($app3->ajax_process());
          break;
        case "inputDbW":
          $app3->inputDb();
          break;
      }
    case "inventory":
      switch($_POST["type"]){
        case "serchItemInv":
          header('Content-Type: application/json');
          echo json_encode($app4->serchItemInv());
          break;
        case "registNums":
          echo $app4->registNums();
          break;
      }
    case "setting":
      switch($_POST['type']){
        case "inventory_reset":
          $app5->inventory_reset();
          break;
        case "med_set_10":
          $app5->med_set_10();
          break;
      }
    case "inventory_table_input":
      $app6->post();
      break;
  }
}