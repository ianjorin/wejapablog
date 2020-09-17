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
        $id = trim($_POST['id']);
		$name = trim($_POST['name']);
		$title= trim($_POST['title']);
		$content= trim($_POST['content']);
	   
		

		if(empty($name) || empty($title) || empty($content)  ){
			error('Please fill all required fields');
			go();
        }
        
        try{
	 
		$database->beginTransaction();

		$sql = "UPDATE posts SET  `author`= :name, `title` = :title , `content` = :content
		
	    WHERE id = :id ";
	
        $result = $database->prepare($sql);
        $result->bindValue('id',$id,PDO::PARAM_INT);
		$result->bindValue('name',$name,PDO::PARAM_STR);
		$result->bindValue('title',$title,PDO::PARAM_STR);
		$result->bindValue('content',$content,PDO::PARAM_STR);
		
        $result->execute();

        
        
		

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
            
            $sql= "UPDATE post_gallery SET `path` = :path WHERE post_id=:id ";

            $result2 = $database->prepare($sql);
            $result2->bindValue('id',$id,PDO::PARAM_INT);
            $result2->bindValue('path',$new_file_name,PDO::PARAM_STR);
            $result2->execute();
			
			
			
		if($result->rowCount() > 0 && $result2->rowCount() > 0   ){
			 $database->commit();
           			success('Update Successful');
				   	go();
               }else{
				   $database->rollBack();
				   error("An Error Occured");
                	go();
				}

            
 }catch(PDOException $e){
					$database->rollBack();
					die($e->getMessage());
 					error('An error occurred');
					go();
			}

	
