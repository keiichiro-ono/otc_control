<?php

namespace MyApp;

class Inventory_table_input extends Controller{

  public function getAll(){
    $sql = "select *,otc_list.id as mainId 
        from 
          otc_list,otc_class 
        where 
          otc_list.class=otc_class.id
        order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function post(){
    $sql = "update otc_list set stock_nums=:nums, inventory=1, modified=now() where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":nums"=>$_POST['nums'],
      ":id"=>$_POST['id']
    ]);
  }

}
