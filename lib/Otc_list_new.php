<?php

namespace MyApp;

class Otc_list_new extends Controller{

  public function allItem(){
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName, otc_list.created as otc_created from otc_list,otc_class,wholesale where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id order by otc_list.created desc limit 20";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function check_self_med($num){
    return $num==1 ? '★' : '';
  }

}
