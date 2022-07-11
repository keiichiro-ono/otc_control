<?php

namespace MyApp;

class Inventory_table_check extends Controller{

  public function getAll(){
    $sql = "select *,otc_list.id as mainId from otc_list,otc_class where otc_list.class=otc_class.id and inventory=0 order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

}
