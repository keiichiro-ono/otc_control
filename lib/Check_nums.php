<?php

namespace MyApp;

class Check_nums extends Controller{

  public function check_nums_all(){
    // $sql = "select distinct otc_id from inventory order by otc_id";
    $sql = "select distinct id as otc_id from otc_list order by id";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // $res = $stmt->fetchColumn();
    return $res;
  }

  public function check_log_inventory($id){

  }

  public function get_inventory_nums_date($id){
    $sql = "select nums,date from inventory where otc_id=$id order by date desc limit 1";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    return $res;
  }

  public function get_log_nums_date($id){
    $sql = "select new_nums as nums,date_format(created, '%Y-%m-%d') as date from nums_change_log where otc_id=$id and created > '2022-08-02' order by created desc limit 1";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    return $res;
    
  }

  public function check_id_to_in_nums($id, $date){
    $sql = "select sum(enter_nums) from warehousing where otc_id=$id and date > '$date 00:00:00'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function check_id_to_out_nums($id, $date){
    $sql = "select sum(nums) from saledata where otc_id=$id and date > '$date 00:00:00'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function check_id_to_return_nums($id, $date){
    $sql = "select sum(nums) from returneddata where otc_id=$id and date > '$date 00:00:00'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  // public function check_id_to_change_nums($id, $date){
  //   $sql = "select sum(new_nums-old_nums) from nums_change_log where otc_id=$id and created > '2022-08-02 00:00:00'";
  //   $stmt = $this->_db->query($sql);
  //   $res = $stmt->fetchColumn();
  //   return $res;
  // }

  public function getNums($id){
    $sql = "select stock_nums from otc_list where id=$id";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function getOtcData($id){
    $sql = "select * from otc_list where id=$id";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $res;
  }
}
