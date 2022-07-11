<?php

namespace MyApp;

class Otc_list_2 extends Controller{

  public function allItem(){
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName from otc_list,otc_class,wholesale where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function sortItem(){
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName from otc_list,otc_class,wholesale where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id order by ". $_GET['sort'];
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function extractItem(){
    switch ($_GET['extract']){
      case 'a':
        $extract = "'^あ|^い|^う|^え|^お'";
        break;
      case 'ka':
        $extract = "'^か|^き|^く|^け|^こ|^が|^ぎ|^ぐ|^げ|^ご'";
        break;
      case 'sa':
        $extract = "'^さ|^し|^す|^せ|^そ|^ざ|^じ|^ず|^ぜ|^ぞ'";
        break;
      case 'ta':
        $extract = "'^た|^ち|^つ|^て|^と|^だ|^ぢ|^づ|^で|^ど'";
        break;
      case 'na':
        $extract = "'^な|^に|^ぬ|^ね|^の'";
        break;
      case 'ha':
        $extract = "'^は|^ひ|^ふ|^へ|^ほ|^ば|^び|^ぶ|^べ|^ぼ|^ぱ|^ぴ|^ぷ|^ぺ|^ぽ'";
        break;
      case 'ma':
        $extract = "'^ま|^み|^む|^め|^も'";
        break;
      case 'ya':
        $extract = "'^や|^ゆ|^よ'";
        break;
      case 'ra':
        $extract = "'^ら|^り|^る|^れ|^ろ'";
        break;
      case 'wa':
        $extract = "'^わ'";
        break;
      case '8':
        $extract = 8;
        return $this->_extractItem_tax(8);
      case '10':
        $extract = 10;
        return $this->_extractItem_tax(10);
      }
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName from otc_list,otc_class,wholesale where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id and otc_list.kana REGEXP ". $extract. " order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  private function _extractItem_tax($num){
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName from otc_list,otc_class,wholesale where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id and otc_list.tax=". (int)$num. " order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function check_self_med($num){
    return $num==1 ? '★' : '';
  }

}
