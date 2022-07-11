<?php

namespace MyApp;

class Setting extends Controller{

  public function inventory_reset(){
    $sql = "update otc_list set inventory=0";
    $this->_db->query($sql);
  }

  public function med_set_10(){
    $sql = "update otc_list
              set
                tax=10,
                tax_include_price=round(selling_price*1.1,0),
                modified=now()
              where
               id in (select id from (select id from otc_list where class!=5) as tmp)
            ";
    $this->_db->query($sql);
    $sql_2 = "select count(*) from otc_list where class!=5";
    $stmt_2 = $this->_db->query($sql_2);
    $res = $stmt_2->fetchcolumn();
    echo $res;
    exit;
  }

}
