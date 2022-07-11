<?php

namespace MyApp;

class Calendar extends Controller{

	public function getSaleDate($ym){
		$sql = "select distinct date from saleData where date like :date order by date";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute([
			":date"=>$ym."%"
		]);
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	public function getSaleData($ym){
		$sql = "select *,sum(saleData.nums) as totalNums,sum(saleData.actual_price*nums) as totalPrice from saleData,otc_list where
							saleData.otc_id=otc_list.id and
							saleData.date like :date group by otc_list.id order by totalPrice desc";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute([
			":date"=>$ym."%"
		]);
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	public function getProceeds($ymd){
		$sql = "select * from saleData,otc_list where saleData.otc_id=otc_list.id and saleData.date=".$ymd;
		$stmt = $this->_db->query($sql);
		return $stmt->fetchAll(\PDO::FETCH_OBJ);

	}

	public function getSalePrice($ym){
		$sql = "select sum(actual_price*nums) from saleData where date like :date";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute([
			":date"=>$ym."%"
		]);
		return $stmt->fetchColumn();
	}

	public function getSum($ymd){
		$sql = "select sum(actual_price*nums) from saleData where saleData.date=".$ymd;
		$stmt = $this->_db->query($sql);
		return $stmt->fetchColumn();
	}


// 返品
	public function getReturned($ymd){
		$sql = "select * from returnedData,otc_list where returnedData.otc_id=otc_list.id and returnedData.date=".$ymd;
		$stmt = $this->_db->query($sql);
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	public function getSumReturned($ymd){
		$sql = "select sum(actual_price*nums) from returnedData where returnedData.date=".$ymd;
		$stmt = $this->_db->query($sql);
		return $stmt->fetchColumn();
	}

// 仕入れ
	public function getWarehousing($ymd){
		$sql = "select * from warehousing,otc_list where warehousing.otc_id=otc_list.id and warehousing.date=".$ymd;
		$stmt = $this->_db->query($sql);
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	public function getSumWarehousing($ymd){
		$sql = "select sum(actual_price*enter_nums) from warehousing where warehousing.date=".$ymd;
		$stmt = $this->_db->query($sql);
		return $stmt->fetchColumn();
	}



}
