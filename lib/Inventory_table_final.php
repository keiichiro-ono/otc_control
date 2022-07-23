<?php

namespace MyApp;

class Inventory_table_final extends Controller{

  public function getAll(){
    $sql = "select *,otc_list.id as mainId from otc_list,otc_class where otc_list.class=otc_class.id and inventory=1 and stock_nums!=0 order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function save_csv(){
    $sql = "select
      otc_list.id as mainId,otc_list.name,otc_list.size,otc_list.purchase_price,otc_list.stock_nums,otc_list.purchase_price*otc_list.stock_nums as subtotal
      from otc_list,otc_class where otc_list.class=otc_class.id and inventory=1 and stock_nums!=0 order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $data;

  }

}
