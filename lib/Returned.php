<?php

namespace MyApp;

class Returned extends Controller{

  public function search(){
    $sql = "select * from otc_list where jan=". $_POST['jan'];
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    // var_dump($res);exit;
    return !$res ? false : $res;
  }

  public function inputDb(){
    $this->_db->beginTransaction();
    try{
      $sql = "insert into returnedData (
        date, otc_id, nums, actual_price, created, modified
      ) values (
        :date, :otc_id, :nums, :actual_price, now(), now()
      )";
      $stmt = $this->_db->prepare($sql);
      $stmt->execute([
        ":date"=>$_POST['ymd'],
        ":otc_id"=>(int)$_POST['id'],
        ":actual_price"=>$_POST['price'],
        ":nums"=>(int)$_POST['nums']
      ]);

      $sql = "update otc_list set stock_nums=stock_nums-:num where id=:id";
      $stmt = $this->_db->prepare($sql);
      $stmt->execute([
        ":num"=>(int)$_POST['nums'],
        ":id"=>(int)$_POST['id']
      ]);

      $sql = "select name from otc_list where id=".(int)$_POST['id']. " limit 1";
      $stmt = $this->_db->query($sql);
      $res = $stmt->fetchColumn();

      $this->_db->commit();
      return $res;

    }catch(\PDOException $e){
      $this->_db->rollback();
      echo $e->getMessage();
    }

  }

  public function threeDay(){
    $today = date("Y-m-d");
    $threeDayAgo = date("Y-m-d",strtotime("-60 day"));
    $sql = "select * from returnedData,otc_list where
      otc_list.id=returnedData.otc_id and
      returnedData.date between '".$threeDayAgo."' and '".$today. "' order by returnedData.date desc, otc_list.kana";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

}
