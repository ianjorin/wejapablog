<?php 

        ini_set("log_errors", 1);
        ini_set("error_log", "php-error.log");
        error_log( "Hello, errors!" );
        ob_start();
        session_start();
        require_once('../config/constants.php');
        require_once('../functions.php');
        require_once('../classes/picture.class.php');
        require_once('../pdo_connection.php');
        
        global $database;
		$name = trim($_POST['name']);
		$title= trim($_POST['title']);
		$content= trim($_POST['content']);
		$id = $_SESSION['user_id'];
	   
		

		if(empty($name) || empty($title) || empty($content)  ){
			error('Please fill all required fields');
			go();
        }
        
        try{
	 
		$database->beginTransaction();

		$sql = "INSERT INTO posts( `author`, `title`, `content` , `userid`)
		
	    VALUES(:name, :title, :content ,:userid)";
	
		$result = $database->prepare($sql);
		$result->bindValue('name',$name,PDO::PARAM_STR);
		$result->bindValue('title',$title,PDO::PARAM_STR);
		$result->bindValue('content',$content,PDO::PARAM_STR);
		$result->bindValue('userid',$id,PDO::PARAM_INT);
		
        $result->execute();

        $id = $database->lastInsertId();
        
		

		$join = '';	
		$media_status = true;
		$picture = new Photograph;
		
		if($_FILES['main_picture']['size'] == 0){
			$database->rollBack();
			error('Please upload main picture');
			   go();
		}
			
		if($_FILES['main_picture']['size'] > MAX_ITEM_PICTURE_UPLOAD_SIZE){
				$database->rollBack();
				error('The size of the Main picture is greater than the maximum size required');
                go();
		}
		
			$file_name = $picture->save($_FILES['main_picture'],uniqid().$id.time(),ADMIN_ITEM_PATH);
			
			
				if($file_name == false){
					$database->rollBack();
					error('Invalid file Main Picture');
					go();
				}
			
					
			$new_file_name = str_replace(ADMIN_ITEM_PATH,'',$file_name);

			$sql= "INSERT INTO post_gallery(`post_id`,`path`) VALUES($id,'$new_file_name')";	
		
		$result2  = $database->query($sql);
			
		if($result->rowCount() > 0 && $result2->rowCount() > 0   ){
			 $database->commit();
           			success('Added Successful');
				   	go();
               }else{
				   $database->rollBack();
				   die('xsxsx');
				   error();
                	go();
				}

            
 }catch(PDOException $e){
					$database->rollBack();
					die($e->getMessage());
 					error('An error occurred');
					go();
			}

	