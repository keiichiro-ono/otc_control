<?php

namespace MyApp;

class Sale extends Controller{

  public function mg_id(){
    $sql = "select max(mg_id) from sales_record";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  public function ajax_process(){
    $sql = "select * from otc_list where jan=". $_POST['jan'];
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    if($res){
      if(!$res['img']){
        $res['img'] = '<span class="fa-stack fa-2x"><i class="fa fa-camera fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
      } else {
        $res['img'] = '<img src="img/'. $res['img']. '" class="img-thumbnail" alt="写真">';
      }
      return $res;
    } else {
      return false;
    }
  }

  public function inputDb(){
    $this->_db->beginTransaction();
    try{
      $sql = "insert into sales_record (
        mg_id, otc_id, sale_nums, actual_price, created, modified
      ) values (
        :mg_id, :otc_id, :sale_nums, :actual_price, now(), now()
      )";
      $stmt = $this->_db->prepare($sql);
      $stmt->execute([
        ":mg_id"=>(int)$_POST['mgId'],
        ":otc_id"=>(int)$_POST['id'],
        ":actual_price"=>(int)$_POST['price'],
        ":sale_nums"=>(int)$_POST['nums']
      ]);

      $sql = "update otc_list set stock_nums=stock_nums-:num where id=:id";
      $stmt = $this->_db->prepare($sql);
      $stmt->execute([
        ":num"=>(int)$_POST['nums'],
        ":id"=>(int)$_POST['id']
      ]);

      $this->_db->commit();
    }catch(\PDOException $e){
      $this->_db->rollback();
      echo $e->getMessage();
    }

  }

}
