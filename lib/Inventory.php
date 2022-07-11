<?php

namespace MyApp;

class Inventory extends Controller{

  public function allItem(){
    $sql = "select *,otc_list.id as mainId from otc_list,otc_class where otc_list.class=otc_class.id and inventory=1 order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function delete_inventory(){
    $sql = "update otc_list set inventory=0";
    $this->_db->query($sql);
  }

  public function serchItemInv(){
    $sql = "select * from otc_list where jan=". $_POST['jan'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function registNums(){
    $sql = "update otc_list set stock_nums=:nums, inventory=1, modified=now() where jan=:jan";
    $stmt = $this->_db->prepare($sql);
    $res = $stmt->execute([
      ":nums"=>$_POST['nums'],
      ":jan"=>$_POST['jan']
    ]);
    return $res;
  }

}
