<?php

namespace MyApp;

class Controller {
	protected $_db;

	public function __construct(){
		try {
			$this->_db = new \PDO(DSN, DB_USER, DB_PASSWORD);
			$this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (\PDOException $e) {
			echo $e->getMessage();
			exit;
		}
	}


}
