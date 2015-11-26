<?php
	// namespace db;

	interface iModel {
	    public function toArray($id);
			public function save($data);
	}


	class DB
  {
		private $_connection;
		private static $_instance; //The single instance
		private $_host = DB_HOST;
		private $_username = DB_USER;
		private $_password = DB_PASS;
		private $_database = DB_NAME;

		public static function getInstance() {
			if(!self::$_instance) { // If no instance then make one
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		private function __construct() {
			$this->_connection = new mysqli($this->_host, $this->_username,
				$this->_password, $this->_database);

			// Error handling
			if($this->_connection->connect_errno) {
				echo "error";
				trigger_error("Failed to conencto to MySQL: " . $this->_connection->connect_errno,
					 E_USER_ERROR);
			}
		}

		static function parseValues($data){
      $values = "";
			$keys   = "";

      foreach ($data as $key => $value) {
				$value = htmlspecialchars($value);
        if(!empty($values)){
          $values .= ", '".$value."'";
					$keys .= ", ".$key;
        }else{
          $values .= "'".$value."'";
					$keys .= $key;
        }
      }
      return array(
				"keys"   => $keys,
				"values" => $values
			);
    }



		private function __clone() { }

		public function getConnection() {
			return $this->_connection;
		}

    function close(){
      $this->conn->close();
    }

  }

?>
