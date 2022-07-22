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
    

      }
          
    case "inventory":
      $app = new \MyApp\Inventory();
      try{
        switch($_POST['mode']){
          case 'inventory_save':
            $res = $app->inventory_save();
            echo $res;
            break;
        }
        exit;
      }catch(Exception $e){
        echo $e->getMessage();
        exit;
      }

  
  } 




    // case "correct_otc":
    //   echo $app->delete_img($_POST['id']);
    //   break;
    // case "sale":
    //   switch($_POST["type"]){
    //     case "check_id":
    //       echo $app2->mg_id() + 1;
    //       break;
    //     case "inputDb":
    //       $app2->inputDb();
    //       break;
    //     case "searchItem":
    //       header('Content-Type: application/json');
    //       echo json_encode($app2->ajax_process());
    //       break;
    //   }
        
      //   case "searchItemW":
      //     header('Content-Type: application/json');
      //     echo json_encode($app->ajax_process());
      //     break;
      //   case "inputDbW":
      //     $app->inputDb();
      //     break;
      // }
    // case "inventory":
    //   switch($_POST["type"]){
    //     case "serchItemInv":
    //       header('Content-Type: application/json');
    //       echo json_encode($app4->serchItemInv());
    //       break;
    //     case "registNums":
    //       echo $app4->registNums();
    //       break;
    //   }
    // case "setting":
    //   switch($_POST['type']){
    //     case "inventory_reset":
    //       $app5->inventory_reset();
    //       break;
    //     case "med_set_10":
    //       $app5->med_set_10();
    //       break;
    //   }
    // case "inventory_table_input":
    //   $app6->post();
    //   break;
}
