<?php

namespace MyApp;

class Correct_otc extends Controller{

  public function item($id){
    $sql = "select *,otc_list.id as mainId,wholesale.name as wholesaleName,otc_list.name as otcName from otc_list,otc_class,wholesale
      where otc_list.class=otc_class.id and otc_list.wholesale=wholesale.id and otc_list.id=". (int)$id;
    $stmt = $this->_db->query($sql);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public function check_self_med($num){
    if($num==="1"){
      return '<mark><i class="bi bi-star text-warning"></i> checked!</mark>';
    } else {
      return "<mark>no checked</mark>";
    }
  }

  public function check_hygiene($num){
    if($num==="1"){
      return '<mark>checked!</mark>';
    } else {
      return "<mark>no checked</mark>";
    }
  }

  public function check_tax($num){
    if($num==="8"){
      return '<mark>8% checked!</mark>';
    } else {
      return "<mark>10% no check</mark>";
    }
  }

  public function check_tokutei_kiki($num){
    if($num==="1"){
      return '<mark>特定医療管理機器 checked!</mark>';
    } else {
      return "<mark>no check</mark>";
    }
  }


  public function class_name(){
    $sql = "select * from otc_class";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getWholesaleName(){
    $sql = "select * from wholesale";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function check_imgfile($string){
    return file_exists($string) ? $string : "";
  }

  public function delete_img($id){
    $sql = "update otc_list set img=null, modified=now() where id=". $id;
    $stmt = $this->_db->query($sql);
    var_dump($stmt);exit;
    if($stmt){
      $ad = 'img/'. sprintf('%03d', $id). '.jpeg';
      unlink($ad);
      clearstatcache(true);
      return true;
    }
  }

  public function postprocess(){
    try{
      // var_dump($_POST);exit;
      $this->_validate();
      $this->_update();
    }catch(\Exception $e){
      echo $e->getMessage();
      exit;
    }
  }

  private function _validate(){
    if(
      $_POST['name'] == "" ||
      $_POST['kana'] == "" ||
      $_POST['stock_nums'] == "" ||
      $_POST['jan'] == "" ||
      $_POST['size'] == "" ||
      $_POST['purchase_price'] == "" ||
      $_POST['selling_price'] == ""
    ){
      throw new \Exception("空欄がありますよ");
    }

    if (
      !preg_match("/^[0-9]+$/", $_POST['stock_nums']) ||
      !preg_match("/^[0-9]+$/", $_POST['jan']) ||
      !preg_match("/^[0-9]+(\.[0-9]*)?$/", $_POST['purchase_price']) ||
      !preg_match("/^[0-9]+$/", $_POST['selling_price'])
    ) {
      throw new \Exception("数字は半角数字だよ");
    }

    $sql = "select count(*) from otc_list where jan=:jan and id!=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":jan"=>$_POST['jan'],
      ":id"=>$_POST['id']
    ]);
    $res = $stmt->fetchColumn();
    if($res === "1"){
      throw new \Exception("同じJANコードがありますよ");
    }

    $sql = "select * from otc_list where id=". $_POST['id'];
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    $self_med = (isset($_POST['self_med'])) ? "1" : "0";
    $hygiene = (isset($_POST['hygiene'])) ? "1" : "0";
    $tokutei_kiki = (isset($_POST['tokutei_kiki'])) ? "1" : "0";
    $tax = (isset($_POST['tax'])) ? "8" : "10";
    if(
      $res['jan']==$_POST['jan'] &&
      $res['name']==$_POST['name'] &&
      $res['kana']==$_POST['kana'] &&
      $res['size']==$_POST['size'] &&
      $res['purchase_price']==$_POST['purchase_price'] &&
      $res['selling_price']==$_POST['selling_price'] &&
      $res['tax']==$tax &&
      $res['stock_nums']==$_POST['stock_nums'] &&
      $res['class']==$_POST['class'] &&
      $res['self_med']==$self_med &&
      $res['wholesale']==$_POST['wholesale'] &&
      $res['hygiene']==$hygiene &&
      $res['tokutei_kiki']==$tokutei_kiki
       // && $_FILES["imgFile"]["size"] == 0
    ){
      throw new \Exception("なんも変わってないね");
    }
    clearstatcache(true);
  }

  private function _update(){
    $sql = "update otc_list set
        jan=:jan,
        class=:class,
        name=:name,
        kana=:kana,
        size=:size,
        purchase_price=:purchase_price,
        selling_price=:selling_price,
        tax=:tax,
        tax_include_price=:tax_include_price,
        stock_nums=:stock_nums,
        self_med=:self_med,
        wholesale=:wholesale,
        hygiene=:hygiene,
        tokutei_kiki=:tokutei_kiki,
        modified=now()
      where id=:id";
    $stmt = $this->_db->prepare($sql);
    $self_med = (isset($_POST['self_med'])) ? "1" : "0";
    $hygiene = (isset($_POST['hygiene'])) ? "1" : "0";
    $tokutei_kiki = (isset($_POST['tokutei_kiki'])) ? "1" : "0";
    $tax = (isset($_POST['tax'])) ? TAX_1 : TAX_2;
    $tax_include_price = round($_POST['selling_price']*(1+$tax/100));
    $stmt->execute([
      ":jan"=>$_POST['jan'],
      ":class"=>(int)$_POST['class'],
      ":name"=>$_POST['name'],
      ":kana"=>$_POST['kana'],
      ":size"=>$_POST['size'],
      ":purchase_price"=>$_POST['purchase_price'],
      ":selling_price"=>(int)$_POST['selling_price'],
      ":tax"=>(int)$tax,
      ":tax_include_price"=>$tax_include_price,
      ":stock_nums"=>(int)$_POST['stock_nums'],
      ":self_med"=>$self_med,
      ":wholesale"=>(int)$_POST['wholesale'],
      ":hygiene"=>$hygiene,
      ":tokutei_kiki"=>$tokutei_kiki,
      ":id"=>(int)$_POST['id']
    ]);
    if(!$stmt){
      throw new \Exception('更新エラー');
    }
  }

  public function save_file($id){
    $fileName = sprintf('%03d', $id). '.jpeg';
    $savePath = IMG_DIR. $fileName;
		$res = move_uploaded_file($_FILES['imgFile']['tmp_name'], $savePath);
		if($res===false){
			throw new \Exception("アップロードを失敗！");
		}
    $sql = "update otc_list set img=:img where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":img"=>$fileName,
      ":id"=>$id
    ]);

  }

}
