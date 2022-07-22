<?php

namespace MyApp;

class Inventory_old extends Controller{

  public function get_days(){
    $sql = "select distinct date from inventory";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

  public function get_day_items($day){
    $sql = "select * from inventory where date='$day'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }


}
