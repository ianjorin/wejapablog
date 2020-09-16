<?php



/**

 * handles the user login/logout/session

 * @author Panique

 * @link http://www.php-login.net

 * @link https://github.com/panique/php-login-advanced/

 * @license http://opensource.org/licenses/MIT MIT License

 */

class User

{

 

    private $user_is_logged_in = false;
  
   

	public function __construct(){

		

	} 

	

    private function newRememberMeCookie()

    {
       global $database;
		

        // if database connection opened

        if ($database) {

	

			try{

            // generate 64 char random string and store it in current user data

			//l

			

			 $time = time();

             $random_token_string = hash('sha256', mt_rand());

			 $sql = "UPDATE users SET last_login = :time, user_rememberme_token = :user_rememberme_token WHERE id = :id";

			 $sth = $database->prepare($sql);

              $sth->bindValue('user_rememberme_token',$random_token_string,PDO::PARAM_STR);
			  $sth->bindValue('id',$_SESSION['user_id'],PDO::PARAM_INT);
			  $sth->bindValue('time',time(),PDO::PARAM_INT);
              $sth->execute();

			

			

            // generate cookie string that consists of userid, randomstring and combined hash of both

			

            $cookie_string_first_part = $_SESSION['user_id'] . ':' . $random_token_string;
            $cookie_string_hash = hash('sha256', $cookie_string_first_part . COOKIE_SECRET_KEY);
            $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;
			$time = time() + COOKIE_RUNTIME;

            // set cookie

            setcookie('rememberme',dd, $cookie_string,$time,'/');


		}catch(PDOException $e){

			//die($e->getMessage());

			}

        }

    }













    public function loginWithCookieData()
    {

		global $database;
        if (isset($_COOKIE['rememberme'])) {
			
            // extract data from the cookie

            list ($user_id, $token, $hash) = explode(':', $_COOKIE['rememberme']);

				
				if(!empty($user_id)&& !empty($token) && !empty($hash)){

				 $sql = "SELECT id,email,first_name FROM users WHERE id = :user_id AND user_rememberme_token = :user_rememberme_token AND user_rememberme_token IS NOT NULL";
				$sth = $database->prepare($sql);

                    $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $sth->bindValue(':user_rememberme_token', $token, PDO::PARAM_STR);
                    $sth->execute();

				if($sth->rowCount() > 0){

                    // get result row (as an object)

                    $data = $sth->fetch(PDO::FETCH_ASSOC);

				session_regenerate_id();
				$_SESSION['user_id'] = $data['id'];
				$_SESSION['email'] = $data['email'];
				$_SESSION['first_name'] = $data['first_name'];
				$_SESSION['logged_in'] = true;
				$_SESSION['userAgent'] = $this->hashSessionData($_SERVER['HTTP_USER_AGENT']);
				$_SESSION['rmt_address'] = $this->hashSessionData($_SERVER['REMOTE_ADDR']);
				

				

				$time = time();
				$sql = "UPDATE users SET last_login = $time WHERE id= :id ";
                $query_user = $database->prepare($sql);
                $query_user->bindValue('id', $_SESSION['user_id'], PDO::PARAM_INT);
                $query_user->execute(); ;

				  return true;
				}else{
					setcookie("rememberme", "", time() - 3600);
					  return false;
					}
				}else{
					setcookie("rememberme", "", time() - 3600);
					  return false;
					
					}

				

				

        }

      

    }







	public function checkLoginStatus2(){

		if (!empty($_SESSION['user_id']) ) {

            $this->loginWithSessionData();

        }elseif(isset($_COOKIE['rememberme'])) {
				
            $this->loginWithCookieData();

        }else{

			$this->securityLogout();

			redirect_to('../index.php');

			}

		}

	

		

		public function checkLoginStatusForLoginPage(){
			if (!empty($_SESSION['user_id']) ) {
				$this->loginWithSessionData();
				go('../views/portal');

			}elseif(isset($_COOKIE['rememberme'])) {
				if($this->loginWithCookieData() == true){
				go('../views/portal');
				}
			}else{

				$this->securityLogout();
				//redirect_to('../index.php');

				}

		}

            // set cookie

		public function checkLoginStatus($go = ''){

			if( isset($_SESSION['user_id'])){
						if (!empty($_SESSION['user_id']) ) {
						$this->loginWithSessionData();
						return true;
					}elseif(isset($_COOKIE['rememberme'])) {
						$this->loginWithCookieData();
						return true;
					}else{
						$this->securityLogout();
							if(!empty($go)){
								redirect_to($go);
							}
						}
	
			}else{
				$this->securityLogout();
							if(!empty($go)){
								redirect_to($go);
							}
			}
		
		

		}

	

	public function securityLogout(){
		unset($_SESSION['user_id'] ,$_SESSION['email'],$_SESSION['userAgent'],$_SESSION['rmt_address']);
		 unset($_COOKIE['rememberme']);
   		 setcookie('rememberme', '', time() - 3600, '/');

 }

	


	public function hashSessionData($data) {
				$salt = SALT; 
				$password = crypt($data,$salt);
				return $password;

}

	 



    private function loginWithSessionData()

    {
        $this->user_is_logged_in = true;

    }



   


  

	 public function checkUserExist($email,$phone=''){
		 global $database;
//OR phone=:phone
		 $sql="SELECT id FROM users WHERE email=:email ";
		 $result=$database->prepare($sql);
		 $result->bindValue('email',$email,PDO::PARAM_STR);
	//	  $result->bindValue('phone',$phone,PDO::PARAM_STR);
		  $result->execute();
		  return $result;
		 
	 }


public function checkLogin($post){
	global $database;



		$jwt = $post->token;
		
 		//$token = JWT::decode($jwt, $secretKey, array('HS512'));
		$sql= 'SELECT id,email,	send_email,active, web_hash_token from users WHERE web_token = :token LIMIT 1';
 		$result = $database->prepare($sql);
		$result->bindValue('token',$jwt,PDO::PARAM_STR);
		$result->execute(); 

		
        if ($result->rowCount() >0){
					$data = $result->fetch(PDO::FETCH_ASSOC);
					

					if($data['active']==1){
						
						if(password_verify($jwt, $data['web_hash_token'])){
							echo json_encode(array('status'=>'success','send_email'=>$data['send_email'],'email'=>$data['email']));
							die;
						}else{
							echo json_encode(array('status'=>'error'));
							die;
						}

					}else{
						echo json_encode(array('status'=>'error'));
						die;
					}





			
				//  die;
    	 }else{
			 echo json_encode(array('status'=>'error'));
			 die;
		 }

}


	public function login(){
		global $database;
		$email = strtolower(trim($_POST['email']));
		$password = trim($_POST['password']);

		
		if(!empty($email) && !empty($password)){
			
			$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
			$sql="SELECT id, email,firstname,password,active FROM users WHERE email=:email";
			$result=$database->prepare($sql);
			$result->bindValue('email',$email,PDO::PARAM_STR);
			$result->execute();
			
			if($result->rowCount()>0){
				
					$data=$result->fetch(PDO::FETCH_ASSOC);

					if($data['active']==1){
						
							if(password_verify($password, $data['password'])){
								
								
								session_regenerate_id();
								$_SESSION['user_id'] = $data['id'];
								$_SESSION['first_name'] = $data['first_name'];

								$_SESSION['email'] = $email;
								$_SESSION['logged_in'] = true;
								//$_SESSION['userAgent'] = $this->hashSessionData($_SERVER['HTTP_USER_AGENT']);
								//$_SESSION['rmt_address'] = $this->hashSessionData($_SERVER['REMOTE_ADDR']);
								
			
								go('../index');
				
		

							}else{
								error('Invalid email / password combination');
								go();
							}


					}else{
						error('Your account has been suspended. Please contact admin');
						go();
					}
			}else{
				error('Invalid email / password combination');
				go();
			}


		}else{
			error('Please enter your email and password');
			go();
		}


	}

      public function register(){
				global $database;
				$first_name = trim($_POST['first_name']);
				$last_name = trim($_POST['last_name']);
				$phone = trim($_POST['phone']);
				$email = strtolower(trim($_POST['email']));
				$password = trim($_POST['password']);

				if(empty($first_name) || empty($last_name) || empty($email) || empty($password)){
					$_SESSION['reg_error'] = 'Please fill all required fields';
					go();
				}

				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$_SESSION['reg_error'] = "Invalid email address";
					go();
				   }

				
			$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
			$user_password_hash = password_hash($password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

        if (!empty($email) && !empty($phone) && !empty($password)){
			
				$status=$this->checkUserExist($email,$phone);

				if($status->rowCount()>0){
					$_SESSION['reg_error'] = 'A user with the email/phone number exists';
					go();
				}
				
				//$database->beginTransaction();
				$sql="INSERT INTO users(`firstname`,`lastname`,`email`,`phone`,`password`,`active`) VALUES(:first_name,:last_name,:email,:phone,:password,:active)";
				$result=$database->prepare($sql);
				$result->bindValue('first_name',$first_name,PDO::PARAM_STR);
		 		$result->bindValue('last_name',$last_name,PDO::PARAM_STR);
				$result->bindValue('email',$email,PDO::PARAM_STR);
		 		$result->bindValue('phone',$phone,PDO::PARAM_STR);
				$result->bindValue('password',$user_password_hash,PDO::PARAM_STR);
			    $result->bindValue('active',1,PDO::PARAM_INT);
				$result->execute();
				$id=$database->lastInsertId();
				
				if($result->rowCount()>0){
					session_regenerate_id();
					$_SESSION['user_id'] = $id;
					$_SESSION['email'] = $email;
					$_SESSION['first_name'] = $first_name;
					$_SESSION['logged_in'] = true;
					//$_SESSION['userAgent'] = $this->hashSessionData($_SERVER['HTTP_USER_AGENT']);
					//$_SESSION['rmt_address'] = $this->hashSessionData($_SERVER['REMOTE_ADDR']);
					
			     	go('../index');
				

			}else{
				$_SESSION['reg_error'] = 'An error occurred. Please try again';
				die;
			}

            }else {

							$_SESSION['reg_error'] = 'An error occurred. Please try again';
							die;

			}

    }
	
	
	public function resetpassword(){

		global $database;
		$email = strtolower(trim($_POST['email']));

		if(empty($email)){
			$_SESSION['reg_error'] = 'Please fill in email';
			go();
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$_SESSION['reg_error'] = "Invalid email address";
			go();
		   }

	if (!empty($email)){
	
		$status=$this->checkUserExist($email);

		if(!$status->rowCount()>0){
			$_SESSION['reg_error'] = 'No user with these email';
			go();
		}
		
		$token = bin2hex(random_bytes(50));
		
		//$database->beginTransaction();
		$sql="INSERT INTO password_reset(`email`,`token`) VALUES(:email,:token)";
		$result=$database->prepare($sql);
		$result->bindValue('email',$email,PDO::PARAM_STR);
		 $result->bindValue('token',$token,PDO::PARAM_STR);
		$result->execute();
		
		$id=$database->lastInsertId();
		
		if($result->rowCount()>0){
			
		    sendPasswordResetLink($email,$token);
			
			 go('../pending.php?email=' . $email. '');
		

	}else{
		$_SESSION['reg_error'] = 'An error occurred. Please try again';
		die;
	}

	}else {

					$_SESSION['reg_error'] = 'An error occurred. Please try again';
					die;

	}

	}


	public function newpassword(){



		global $database;

		$token = $_POST['token'];

		$password = trim($_POST['password']);
		$password_conf = trim ($_POST['password_conf']);

		$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
		
		if(empty($password) || empty($password_conf)){
			$_SESSION['reset_error'] = 'Please fill all required fields';
			go();
		}

		if ($password !== $password_conf){
			$_SESSION['reset_error'] = 'passwords do not match';
			go();
		}

		

		$sql = "SELECT email FROM password_reset WHERE token= :token LIMIT 1";
		$result=$database->prepare($sql);
		$result->bindValue('token',$token,PDO::PARAM_STR);
		$result->execute();
		 
		if($result->rowCount() > 0){

		$data=$result->fetch(PDO::FETCH_ASSOC);
		
		$email = $data['email'];

		$user_password_hash = password_hash($password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

		$sql = "UPDATE users SET password= :password WHERE email= :email";
		$result=$database->prepare($sql);
		$result->bindValue('email',$email,PDO::PARAM_STR);
		$result->bindValue('password',$user_password_hash,PDO::PARAM_STR);
		$result->execute();

		if($result->rowCount() > 0){
			go('../login');
		}

		}

	}
	






  
	
	public function lastLogin($table){
		 global $database;
		$sql = "UPDATE $table SET last_login = ".time()." WHERE id= :id ";
		$query_user = $database->prepare($sql);
		$query_user->bindValue('id', $_SESSION['user_id'], PDO::PARAM_INT);
		$query_user->execute();
		}

	




		public function facebookLogin($post){
			global $database;
			$first_name = clean($post->first_name);
			$last_name = clean($post->last_name);
			$email = isset($post->email)?clean($post->email):'';	
			$id = clean($post->id);

			
		
			if (!empty($id)){

				$sql = "SELECT id,email FROM users WHERE social_type = :type AND social_id = :id";
				$result = $database->prepare($sql);
				$result->bindValue('type','facebook',PDO::PARAM_STR);
				$result->bindValue('id',$id);
				$result->execute();
			
				if($result->rowCount() > 0){



					
						$data = $result->fetch(PDO::FETCH_ASSOC);
						if(empty($data['email'])){
							encode('email_status','empty','a');
						}

						
					$status=$this->checkUserExist($email);

					if($status->rowCount()>0){
						$status = $status->fetch(PDO::FETCH_OBJ);
						
						if($status->id != $data['id']){
							echo json_encode(array('status'=>'error','action'=>'','msg'=>'A user with the email address exists'));
						die
						;}
					}


						

							//create token
							$tokenId    = (uniqid('', true));
							$issuedAt   = time()+1;
							$notBefore  = $issuedAt;             //Adding 10 seconds
							$expire     = $notBefore + 3000000;            // Adding 60 seconds
							//$serverName = SERVER_NAME; // Retrieve the server name from config file
		
		
						
		
		
					$secretKey = sha1(SALT);
					$token =  $data['id'] . round(microtime(true) *1000) .  $tokenId  . $secretKey;
					$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
					$hash_token = password_hash($token, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

					 $unencodedArray = array('jwt' => $token, 'status'=> 'success','email'=>$data['email']);
					 
						
						   $sql =  "UPDATE users SET web_token = '$token', web_hash_token = '$hash_token' WHERE id=  " .$data['id'];
						   $query= $database->prepare($sql);
						  $query->execute();
						  echo json_encode($unencodedArray);die();
					   


					
				}else{
					if(empty($email)){
						encode('email_status','empty','b');
					}

					$status=$this->checkUserExist($email);

					if($status->rowCount()>0){
						echo json_encode(array('status'=>'error','action'=>'','msg'=>'A user with the email address exists'));
						die;
					}
				
					$sql="INSERT INTO users(`first_name`,`last_name`,`email`,`active`,`social_login`,`social_type`,`social_id`) VALUES(:first_name,:last_name,:email,:active,:social_login,:social_type,:social_id)";
					$result=$database->prepare($sql);
					$result->bindValue('first_name',$first_name,PDO::PARAM_STR);
					 $result->bindValue('last_name',$last_name,PDO::PARAM_STR);
					 $result->bindValue('email',$email,PDO::PARAM_STR);
					 $result->bindValue('social_login',1,PDO::PARAM_INT);
					 $result->bindValue('social_type','facebook',PDO::PARAM_STR);
					 $result->bindValue('social_id',$id);
					  $result->bindValue('active',1,PDO::PARAM_INT);
					$result->execute();
					$id=$database->lastInsertId();





					
							//create token
							$tokenId    = (uniqid('', true));
							$issuedAt   = time()+1;
							$notBefore  = $issuedAt;             //Adding 10 seconds
							$expire     = $notBefore + 3000000;            // Adding 60 seconds
							//$serverName = SERVER_NAME; // Retrieve the server name from config file
		
		
						
		
		
					$secretKey = sha1(SALT);
					$token =  $id . round(microtime(true) *1000) .  $tokenId  . $secretKey;
					$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
					$hash_token = password_hash($token, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
					 $unencodedArray = array('jwt' => $token, 'status'=> 'success','email'=>$email);
					 
						
						   $sql =  "UPDATE users SET web_token = '$token', web_hash_token = '$hash_token' WHERE id=  " .$id;
						   $query= $database->prepare($sql);
						  $query->execute();
						  echo json_encode($unencodedArray);die();





				}



				}else{
					echo json_encode(array('status'=>'error','action'=>'refresh','msg'=>'An error occurred.'));
					die;
				}
	
		}
    







	public function editProfile(){
		global $database;
		$first_name = trim($_POST['first_name']);
		$last_name = trim($_POST['last_name']);  
		$phone = trim($_POST['phone']);  
		$phone2 = trim($_POST['phone2']); 
		$address = trim($_POST['address']);  
		$city = trim($_POST['city']);  
		$country = trim($_POST['country']);  
		$state = trim($_POST['state']);  

		if(empty($first_name)){
			error('Please enter your first name');
			go();
		}

		if(empty($last_name)){
			error('Please enter your last name');
			go();
		}
		

		if(empty($phone)){
			error('Please enter your phone number');
			go();
		}
		
		
		

                $sql = "UPDATE users SET first_name= :first, last_name= :last, phone = :phone, phone2= :phone2, address= :address,city = :city, country= :country, state = :state  WHERE id=:id";
                $result = $database->prepare($sql);
                $result->bindValue('first',$first_name,PDO::PARAM_STR);
                $result->bindValue('last',$last_name,PDO::PARAM_STR);
                $result->bindValue('phone',$phone,PDO::PARAM_STR);
                $result->bindValue('phone2',$phone2,PDO::PARAM_STR);
                $result->bindValue('address',$address,PDO::PARAM_STR);
                $result->bindValue('city',$city,PDO::PARAM_STR);
                $result->bindValue('country',$country);
                $result->bindValue('state',$state);
                $result->bindValue('id',$_SESSION['user_id'],PDO::PARAM_INT);
                $result->execute();
              
                if ($result == true){
               			success('Profile Edited successfully');
                        go();
						
                    }else{
						error('An error occurred');
                      	 go();
					}		


	}
	


	public function editPassword($id, $password, $rpassword){
        global $database;
        if(empty($password)){
			$checkArray = [ 'x_status'=>'error' ,'message' => 'Password required'];
            echo json_encode($checkArray);
			die;
		}else{
            $password  = trim($password);
         					
		}
		
		if(empty($rpassword)){
			$checkArray = [ 'x_status'=>'error' ,'message' => 'Repeat Password required '];
            echo json_encode($checkArray);
			die;
		}else{
            $rpassword = trim($rpassword);
            			
		}
       
		 if ($password !== $rpassword) {
            $unencodedArray = [ 'x_status'=> 'error', 'message'=>'Passwords are not identical'];
                        echo json_encode($unencodedArray);
						die;
        } elseif (strlen($password) < 6) {
             $unencodedArray = [ 'x_status'=> 'error', 'message'=>'Password is meant to be 6 or more characters'];
                        echo json_encode($unencodedArray);
						die;
       
        }
		 $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                  $user_password_hash = password_hash($password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

                $sql = "UPDATE admin SET password= :password WHERE id=:id";
                $result = $database->prepare($sql);
                $result->bindValue('password',$user_password_hash,PDO::PARAM_STR);
                 $result->bindValue('id',$id,PDO::PARAM_INT);
                $result->execute();
                //$result_row= $result->fetch(PDO::FETCH_OBJ);
                if ($result == true){
                $unencodedArray = [ 'x_status'=> 'success', 'message'=> 'Edited successfully'];
                        echo json_encode($unencodedArray);
						die;
                    }else{
						 $unencodedArray = [ 'x_status'=> 'error', 'message'=>'An error occurred'];
                        echo json_encode($unencodedArray);
						die;
					}

           
	
		


	}
	





}

