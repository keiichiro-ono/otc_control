<?php

namespace MyApp;

class Otc_list extends Controller{

  public function allItem(){
    $sql = "select *,otc_list.id as mainId from otc_list,otc_class where otc_list.class=otc_class.id order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function item($jan){
    $sql = "select *,otc_list.id as mainId from otc_list,otc_class where otc_list.class=otc_class.id and otc_list.jan=".$jan;
    $stmt = $this->_db->query($sql);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public function change_self_med($count){
    $res = $count == 1 ? "セルフメディケーション税制対象" : "";
    return $res;
  }
}
