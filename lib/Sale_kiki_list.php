<?php

namespace MyApp;

class Sale_kiki_list extends Controller{

  public function getAllData(){
    $sql = "select *,saledata.id as mainId from saledata,otc_list where
      otc_list.id=saledata.otc_id and
      (otc_list.class=6 or otc_list.tokutei_kiki='1')
      order by saledata.date desc";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

  public function ajax_postprocess(){
    switch($_POST['item']){
      case 'name':
        $item='user_name';
        break;
      case 'address':
        $item = 'user_address';
        break;
      case 'notes':
        $item = 'notes';
        break;
    }
    $sql = "update saledata set $item=:col where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":col"=>$_POST['text'],
      ":id"=>$_POST['id']
    ]);
    return $_POST;
  }


}
