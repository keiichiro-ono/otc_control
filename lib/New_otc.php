<?php

namespace MyApp;

class New_otc extends Controller{

  public function postprocess(){
    try{
      // var_dump($_POST);exit;
      $this->_validate();
      $id = $this->_save();
    }catch(\Exception $e){
      echo $e->getMessage();
      exit;
    }
    return $id;
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


  private function _validate(){
    if(
      $_POST['name'] == "" ||
      $_POST['kana'] == "" ||
      $_POST['stock_nums'] == "" ||
      // $_POST['jan'] == "" ||
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

    $sql = "select count(*) from otc_list where jan=:jan";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([":jan"=>$_POST['jan']]);
    $res = $stmt->fetchColumn();
    if($res === "1"){
      throw new \Exception("同じJANコードがありますよ");
    }
  }

  private function _save(){
    $tax = (isset($_POST['tax'])) ? TAX_1 : TAX_2;
    $tax_include_price = (int)(round($_POST['selling_price']*($tax/100+1)));

    $sql = "insert into otc_list
    (jan, class, name, kana, size, purchase_price, selling_price, tax,  tax_include_price, stock_nums, self_med, wholesale, hygiene, tokutei_kiki, created, modified)
    values
    (:jan, :class, :name, :kana, :size, :purchase_price, :selling_price, :tax,  :tax_include_price, :stock_nums, :self_med, :wholesale, :hygiene, :tokutei_kiki, now(), now())";
    $stmt = $this->_db->prepare($sql);
    $self_med = (isset($_POST['self_med'])) ? true : false;
    $hygiene = (isset($_POST['hygiene'])) ? true : false;
    $tokutei_kiki = (isset($_POST['tokutei_kiki'])) ? true : false;
    $stmt->execute([
      ":jan"=>$_POST['jan'],
      ":class"=>(int)$_POST['class'],
      ":name"=>$_POST['name'],
      ":kana"=>$_POST['kana'],
      ":size"=>$_POST['size'],
      ":purchase_price"=>$_POST['purchase_price'],
      ":selling_price"=>(int)$_POST['selling_price'],
      ":tax"=>$tax,
      ":tax_include_price"=>$tax_include_price,
      ":stock_nums"=>(int)$_POST['stock_nums'],
      ":self_med"=>$self_med,
      ":wholesale"=>(int)$_POST['wholesale'],
      ":hygiene"=>$hygiene,
      ":tokutei_kiki"=>$tokutei_kiki
    ]);

    return $this->_db->lastInsertId();
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
