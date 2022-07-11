<?php

namespace MyApp;

class Sales_calendar extends Controller{

	public function getSale($ymd){
		$sql = "select sum(actual_price*nums) from saleData where
						date=:date";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute([
			":date"=>$ymd
		]);
		return $stmt->fetchColumn();
	}

	public function getReturn($ymd){
		$sql = "select sum(actual_price*nums) from returnedData where
						date=:date";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute([
			":date"=>$ymd
		]);
		return $stmt->fetchColumn();
	}

	public function getWarehousing($ymd){
		$sql = "select sum(actual_price*enter_nums) from warehousing where
						date=:date";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute([
			":date"=>$ymd
		]);
		return $stmt->fetchColumn();
	}






}
