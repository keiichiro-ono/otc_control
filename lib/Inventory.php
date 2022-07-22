<?php

namespace MyApp;

class Inventory extends Controller{

    public function inventory_save(){
		if( $this->check_same_day() > 0){
			echo 'すでに同じ日で棚卸されています';
			exit;
		}

		$this->_db->beginTransaction();

		$items = $this->_getAll();
		if(!$items){
			echo '棚卸を確定しているアイテムがありません！';
			exit;
		}

		try{
			foreach($items as $item){
				$this->_data_save($item);
			}
			$this->_reset_inventory();
			$this->_db->commit();
			echo '正常に終了しました。';
			exit;	

		}catch(\Exception $e){
			$this->_db->rollback();
			echo $e->getMessage();
			exit;
		}
    }

	private function check_same_day(){
		$sql = "select count(*) from inventory where date=DATE_FORMAT(now(),'%y-%m-%d')";
		$stmt = $this->_db->query($sql);
		$cnt = $stmt->fetchColumn();
		return (int)$cnt;
	}

	private function _reset_inventory(){
		$sql = "update otc_list set inventory=0, modified=now()";
		$this->_db->query($sql);
	}

	private function _getAll(){
        $sql = "select *,otc_list.id as mainId,wholesale.name as w_name,otc_list.name as o_name 
			from 
				otc_list,otc_class,wholesale
			where
				otc_list.class=otc_class.id and
				otc_list.wholesale=wholesale.id and
				inventory=1 and
				stock_nums!=0
			order by otc_list.kana";
        $stmt = $this->_db->query($sql);
        $items = $stmt->fetchAll(\PDO::FETCH_OBJ);
		return $items;
	}

    private function _data_save($item){
        $sql = "insert into inventory (date, otc_id, otc_name, otc_kana, otc_size, otc_purchase_price, otc_selling_price, tax, otc_tax_include_price, otc_self_med, otc_wholesale, otc_hygine, otc_class_name, nums, created, modified) values
        (now(), :otc_id, :otc_name, :otc_kana, :otc_size, :otc_purchase_price, :otc_selling_price, :tax, :otc_tax_include_price, :otc_self_med, :otc_wholesale, :otc_hygine, :otc_class_name, :nums, now(), now())";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute([
			":otc_id"=>(int)$item->mainId, 
			":otc_name"=>$item->o_name, 
			":otc_kana"=>$item->kana, 
			":otc_size"=>$item->size, 
			":otc_purchase_price"=>(int)$item->purchase_price, 
			":otc_selling_price"=>(int)$item->selling_price, 
			":tax"=>(int)$item->tax, 
			":otc_tax_include_price"=>(int)$item->tax_include_price, 
			":otc_self_med"=>(int)$item->self_med, 
			":otc_wholesale"=>$item->w_name, 
			":otc_hygine"=>(int)$item->hygiene, 
			":otc_class_name"=>$item->class_name, 
			":nums"=>(int)$item->stock_nums
		]);
    }
}
