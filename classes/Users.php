<?php 
	class Users{
		protected $db;

		public function __construct(){
			$this->db = Database::instance();
		}

		public function get($table, $fields = array()){
			$columns = implode(', ', array_keys($fields));
			//sql query
			$sql = "SELECT * FROM `{$table}` WHERE `{$columns}` = :{$columns}";
			//check if sql query is set
			if($stmt = $this->db->prepare($sql)){
				foreach ($fields as $key => $value) {
					//bind columns
					$stmt->bindValue(":{$key}", $value);
				}
				//execute the query
				$stmt->execute();
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
		}
	 

		public function insert($table, $fields = array()){
			$columns = implode(", ", array_keys($fields));
			$values  = ":".implode(", :", array_keys($fields));
			//sql query
			$sql = "INSERT INTO {$table} ({$columns}) VALUES({$values})";
			//check if sql is prepared
			if($stmt = $this->db->prepare($sql)){
				foreach ($fields as $key => $value) {
					$stmt->bindValue(":{$key}", $value);
				}
				//execute
				$stmt->execute();
				//return user_id
				return $this->db->lastInsertId();
			}
		}

		public function update($table, $fields, $condition){
			$columns  = '';
			$where    = " WHERE ";
			$i        = 1;
			//create columns
			foreach($fields as $name => $value){
				$columns .= "`{$name}` = :{$name}";
				if($i < count($fields)){
					$columns .= ", ";
				}
				$i++;
			}
			//create sql query
			$sql = "UPDATE {$table} SET {$columns}";
			foreach($condition as $name => $value){
				$sql .= "{$where} `{$name}` = :{$name}";
				$where = " AND ";
			}
			
			if($stmt = $this->db->prepare($sql)){
				foreach ($fields as $key => $value) {
					
					$stmt->bindValue(":{$key}", $value);
					foreach ($condition as $key => $value) {
						
						$stmt->bindValue(":{$key}", $value);
					}
				}
				$stmt->execute();
			}
		}

		public function emailExist($email){
			$email = $this->get('details', array('email' => $email));
			return ((!empty($email))) ? $email : false;
		}

		public function redirect($location){
			header("Location: ".BASE_URL.$location);
		}

		public function userData($user_id = varchar){
			return $this->get('details', array('email' => $user_id));
		}

		public function logout(){
			$_SESSION = array();
			session_destroy();
			$this->redirect('index.php');
		}

		public function isLoggedIn(){
			return ((isset($_SESSION['user_id']))) ? true : false;
		}

	}
?>
