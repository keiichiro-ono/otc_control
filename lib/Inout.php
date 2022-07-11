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

  public function getOutData(){
    $sql = "select date,nums,actual_price from saleData
      where otc_id=". $_GET['id'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getInData(){
    $sql = "select date,enter_nums as nums,actual_price, limit_date
    from warehousing where otc_id=". $_GET['id'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getReturnedData(){
    $sql = "select date,nums,actual_price
    from returnedData where otc_id=". $_GET['id'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getOutPrice(){
    $sql = "select sum(actual_price*nums) from saleData where otc_id=". $_GET['id'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  public function getInPrice(){
    $sql = "select sum(actual_price*enter_nums) from warehousing where otc_id=". $_GET['id'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  public function getRetrurnedPrice(){
    $sql = "select sum(actual_price*nums) from returnedData where otc_id=". $_GET['id'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

}
