<?php

require_once('config/config.php');

if($_SERVER['REQUEST_METHOD']==="POST"){
  switch($_POST["url"]){
    case "warehousing":
      $app = new \MyApp\Warehousing();
      try{
        switch($_POST['mode']){
          case 'search':
            $res = $app->search();
            break;
          case 'inputDb':
            $res = $app->inputDb();
            break;
          case 'deleteSubRow':
            $res = $app->deleteSubRow();
            break;
          case 'editSubPrice':
            $res = $app->editSubPrice();
            break;
          case '_serch_last_day':
            $res = $app->_serch_last_day();
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

    case "proceeds":
      $app = new \MyApp\Proceeds();
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

    case "returned":
      $app = new \MyApp\Returned();
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
    
    case "warehousing_kiki_list":
      $app = new \MyApp\Warehousing_kiki_list();
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

    case "sale_kiki_list":
      $app = new \MyApp\Sale_kiki_list();
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
  
    case "inventory_table_input":
      $app = new \MyApp\Inventory_table_input();
      try{
        switch($_POST['mode']){
          case 'inventory_nums':
            $app->post();
            break;
        }
        exit;
      }catch(Exception $e){
        echo $e->getMessage();
        exit;
      }

    case "setting":
      $app = new \MyApp\Setting();
      switch($_POST['mode']){
        case "inventory_reset":
          $app->inventory_reset();
          break;
        case 'delete_wholesale_check':
          $res = $app->delete_wholesale_check();
          echo $res;
          break;
        case 'delete_wholesale':
          $res = $app->delete_wholesale();
          echo $res;
          break;
        case 'create_wholesale':
          $res = $app->create_wholesale();
          echo $res;
          break;
        case 'update_wholesale':
          $app->update_wholesale();
          break;
    
        case 'delete_otc_class_check':
          $res = $app->delete_otc_class_check();
          echo $res;
          break;
        case 'delete_otc_class':
          $res = $app->delete_otc_class();
          echo $res;
          break;
        case 'create_otc_class':
          $res = $app->create_otc_class();
          echo $res;
          break;
        case 'update_otc_class':
          $app->update_otc_class();
          break;
      }
    case "inventory":
      $app = new \MyApp\Inventory();
      switch($_POST['mode']){
        case "inventory_save":
          $app->inventory_save();
          break;
      }
  }
}
