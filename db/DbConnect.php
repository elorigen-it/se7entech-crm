 
<?php 	
	require_once __DIR__ . '/../config/connection.php';

	class DbConnect {

		private $host;
		private $dbName;
		private $user;
		private $pass;

		public function __construct(){
			global $con_host, $con_user, $con_pass, $con_db;
			
			$this->host = $con_host;
			$this->dbName = $con_db;
			$this->user = $con_user;
			$this->pass = $con_pass;
		}
		public function connect() {
			try {
				$conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch( PDOException $e) {
				echo 'Database Error: ' . $e->getMessage();
			}
		}
	}
 ?>