<?php
ob_start();
session_start();
require_once('../config/constants.php');
require_once('../functions.php');
require_once('../classes/picture.class.php');
require_once('../pdo_connection.php');
global $database;
        
        $id = $_GET['id'];
		
		
		$sql = "UPDATE posts SET `deleted`= :deleted  WHERE `id` =:id";
		$result = $database->prepare($sql);
		$result->bindValue('id',$id,PDO::PARAM_INT);
		$result->bindValue('deleted',1,PDO::PARAM_INT);
		$result->execute();
          if ($result == true){
           success('Deleted successfully');
                 
               }
            else{
				    error('An error occured');
               
		 }

		go();