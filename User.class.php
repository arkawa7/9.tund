<?php
class User{

	private $conection;
	
	function __construct($mysqli) {
		
		//this tähendab klassi muutujat
		$this->connection = $mysqli;
		
		

	}
	function createUser($create_email, $hash) {
		
		//teen objekti
		$response = new stdClass();
		
		//kas selline email on olemas
		$stmt = $this->connection->prepare("SELECT id FROM user_sample WHERE email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			// annan errori, et selline email olemas
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise epostiga kasutaja on juba olemas!";
			
			$response->error = $error;
			
			return $response;
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Kasutaja edukalt loodud!";
			
			$response->success = $success;
			return $response;
			
			
			
		}else{
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise epostiga kasutaja on juba olemas!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		return $response;
	}

	function loginUser($email, $hash) {
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if(!$stmt->fetch()){	
			
			
		}else{
			//parool vale
			
			
			
		}
		$stmt->close();
		
	}




	
} ?>