<?php

namespace MyApp;

class Otc48_list extends Controller{


  public function check_stock($otc48_id){
    $sql = "select sum(otc_list.stock_nums) from otc_list,category where otc_list.category_id=category.id and otc_48_id=$otc48_id";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();
  }

  // public function otc48_id_to_cat_id($otc48_id){
  //   $sql = "select * from otc_lis"
  // }

  public function get_med_items(){
    $sql = "select *,otc_list.id as mId from otc_list,otc_class 
      where otc_list.class=otc_class.id and
      otc_list.class>=1 and otc_list.class<=4 order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchALL(\PDO::FETCH_OBJ);
  }

  public function get_items($id){
    $sql = "select *,otc_list.id as mainId from otc_list,category where otc_list.category_id=category.id and otc_48_id=$id order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchALL(\PDO::FETCH_OBJ);
  }

  public function update_cat_id($otc_id, $cat_id){
    $sql = "update otc_list set category_id=:cat_id, modified=now() where id=:otc_id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":cat_id"=>$cat_id,
      ":otc_id"=>$otc_id
    ]);
  }


  public function check_self_med($num){
    return $num==1 ? '★' : '';
  }

}
