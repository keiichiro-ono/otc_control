<?php

namespace MyApp;

class Inventory_table extends Controller{

  public function getAll(){
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName from otc_list,otc_class,wholesale where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

}
