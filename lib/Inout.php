<?php

namespace MyApp;

class Inout extends Controller{

  public function getItem(){
    $sql = "select * from otc_list,otc_class
      where otc_list.class=otc_class.id and otc_list.id=". $_GET['id'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public function getWholesale($id){
    $sql = "select name from wholesale
      where id=$id";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  public function getOutData($id, $date){
    $sql = "select date,nums,actual_price from saleData
      where otc_id=". $_GET['id']. " and date >= '". $date . " 00:00:00'";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getInData($id, $date){
    $sql = "select date,enter_nums as nums,actual_price, limit_date
    from warehousing where otc_id=". $_GET['id']. " and date >= '". $date . " 00:00:00'";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getReturnedData($id, $date){
    $sql = "select date,nums,actual_price
    from returnedData where otc_id=". $_GET['id']. " and date >= '". $date . " 00:00:00'";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getOutPrice($id, $date){
    $sql = "select sum(actual_price*nums) from saleData where otc_id=". $_GET['id']. " and date >= '". $date . " 00:00:00'";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  public function getInPrice($id, $date){
    $sql = "select sum(actual_price*enter_nums) from warehousing where otc_id=". $_GET['id']. " and date >= '". $date . " 00:00:00'";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  public function getRetrurnedPrice($id, $date){
    $sql = "select sum(actual_price*nums) from returnedData where otc_id=". $_GET['id']. " and date >= '". $date . " 00:00:00'";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }


  public function getInventoryItem($id){
    $sql = "select * from inventory where otc_id='$id' order by date desc limit 1";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    return $res;

  }

  public function check_change_log($id, $inventoryDate){
    $sql = "select count(*) from nums_change_log where otc_id=$id and created >= '". $inventoryDate . " 00:00:00'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function change_log($id){
    $sql = "select * from nums_change_log where otc_id=$id";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

}
