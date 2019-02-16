<?php

//membuat koneksi database

class Database{

	private $db_host = 'localhost';
	private $db_name = 'php_api';
	private $db_user = 'root';
	private $db_pass = '';


	public function dbConnection(){
		try {

			$conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name, $this->db_user,$this->db_pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
			
		} catch (PDOException $e) {
			echo "CONNECTION ERROR" . $e->getMessage();
			exit;
		}
	}
}