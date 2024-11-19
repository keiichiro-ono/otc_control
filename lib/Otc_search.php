<?php

namespace MyApp;

class Otc_Search extends Controller{

  public function allItem(){
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName from otc_list,otc_class,wholesale where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function check_self_med($num){
    return $num==1 ? '★' : '';
  }




  public function search_items(){
    $word = mb_convert_kana($_POST["word"], "Hc");
    // $sql = "select * from otc_list where kana like :kana";
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName 
    from otc_list,otc_class,wholesale 
    where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id and otc_list.kana like :kana";
    // order by otc_list.kana";

    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":kana"=> "%". $word. "%"
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function search_item_barcode(){
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName 
    from otc_list,otc_class,wholesale 
    where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id and otc_list.jan=:jan";

    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":jan"=> $_POST['code']
    ]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }



}
