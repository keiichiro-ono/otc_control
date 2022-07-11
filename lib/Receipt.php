<?php

namespace MyApp;

class Receipt extends Controller{

  public function getIdData(){
    $sql = "select * from otc_list,sales_record
      where
        otc_list.id=sales_record.otc_id and
        mg_id=". $_GET['mgId'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getDate(){
    $sql = "select substring(created, 1, 10) from sales_record where mg_id=". $_GET['mgId'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  public function checkSelfMed($n){
    return $n == 1 ? "★" : "";
  }

  public function getList(){
    $sql = "select mg_id,created from sales_record group by mg_id order by mg_id desc";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getDayList(){
    $sql = "select id,date(created) as date from sales_record group by date order by date desc";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getSumPrice(){
    $sql = "select sum(actual_price) from sales_record where mg_id=". $_GET['mgId'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  public function getReceOnDate(){
    $sql = "select * from sales_record
      where date(created)='". $_GET['date']."' group by mg_id order by mg_id desc";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchALL(\PDO::FETCH_OBJ);
  }

  public function existSelfMed($receipt){
    $res = false;
    foreach($receipt as $rece){
      if($rece->self_med==1){
        $res = true;
      }
    }
    return $res;
  }

}
