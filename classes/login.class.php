<?php 

class Login {
	
	
	public function adminLogin(){
		global $database;

		
		$username = $_POST['username'];
		$user_password = $_POST['password'];
        
       try{
		
		$username = trim($username);
		$user_password = trim($user_password);
	
	


		if(empty($username)){
			$_SESSION['error'] = "Pls enter your username";
			redirect_to($_SERVER['HTTP_REFERER']);
			}		
           

		if(empty($user_password)){
			$_SESSION['error'] = "Pls enter your password";
			redirect_to($_SERVER['HTTP_REFERER']);
            }	
            // encode('status','error');
            
		//    $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
		//    $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

		   $sql = "SELECT id, password FROM admin WHERE email = :username AND active = 1 ";
		   $result = query($sql,array(
			   'username'=>$username
		   ));

		   if($result->rowCount() > 0){

			   $data = $result->fetch(PDO::FETCH_OBJ);

				if (password_verify($user_password, $data->password)) {
					session_regenerate_id();
					$_SESSION['user_id'] = $data->id;
					$_SESSION['user_logged_in'] = 1;
					$_SESSION['userAgent'] = $this->hashSessionData($_SERVER['HTTP_USER_AGENT']);
					$_SESSION['rmt_address'] = $this->hashSessionData($_SERVER['REMOTE_ADDR']);
					go('../../index');
				}else{
					error('Invalid username and password');
					go();
				}
		   }else{
			   error('Invalid username and password');
			   go();
		   }
          

       
						
				



    }catch(Exception $e){
        ini_set("log_errors", 1);
		ini_set("error_log", "php-error.log");
		error_log( "======".$e->getMessage() );
	}
	



	}
	




public function checkAdminLogin($go){
	
	if (!empty($_SESSION['user_id']) && ($_SESSION['user_logged_in'] == 1) && ($_SESSION['userAgent'] == $this->hashSessionData($_SERVER['HTTP_USER_AGENT'])) && ($this->hashSessionData($_SERVER['REMOTE_ADDR']) == $_SESSION['rmt_address'])) {
		return true;
	}else{
		
		$this->logout();
		go($go);

	}
}
	

public function hashSessionData($data) {

$salt = SALT;
$password = crypt($data,$salt);
return $password;	
}



	}









?>

