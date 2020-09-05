<?php

function success($message){
	global $global_mobile;
	if($global_mobile == 1){
		echo json_encode(array('status'=>'success','message'=>$message));
		die;
		}
	$_SESSION['success']  = $message;
	
	}

function error($message = "An error occurred. Pls try again"){
		global $global_mobile;
		
	if($global_mobile == 1){
		echo json_encode(array('status'=>'error','message'=>$message));
		die;
		}
	$_SESSION['error']  = $message;
	
	}

    function alert(){
	 if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
		echo '<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h5><i class="icon fas fa-ban"></i> Error!</h5>
		'.$_SESSION['error'].'
	  </div>';

	  unset($_SESSION['error']);
	} else if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
		echo '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h5><i class="icon fas fa-check"></i> Success!</h5>
		'.$_SESSION['success'].'
	  </div>';

	  unset($_SESSION['success']);
	}
}

function go( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}else{
			$location = $_SERVER['HTTP_REFERER'];
			header("Location: {$location}");
			exit;
			
			}
    }
    
    function query($sql,$data){
        global $database;
        $result = $database->prepare($sql);
        foreach($data as $key => $value){
            $result->bindValue("$key",$value);
            }
        $result->execute();
        return $result;
        }