<?php

class Photograph {
	

	
  private $temp_path;
  protected $upload_dir;
  protected $pic_file;
  protected $error = NULL;
  protected $pic;
  protected $file_name;
  protected $target;
  protected  $ext;
  public $name_array = [];
 
  
  protected $upload_errors = array(
		// http://www.php.net/manual/en/features.file-upload.errors.php
		UPLOAD_ERR_OK 				=> "No errors.",
		UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
	  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
	  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
	  UPLOAD_ERR_NO_FILE 		=> "No file selected.",
	  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
	  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
	  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);

	protected $extensions = array('jpg','jpeg','png','gif');


	


	private function check_for_error($file){//1
		if(!$file || empty($file) || !is_array($file)) {
		  // error: nothing uploaded or wrong argument usage
		 $_SESSION['error'] = "No file was uploaded.";
		 return false;
		 
		} elseif($file['error'] != 0) {
		  // error: report what PHP says went wrong
			 $_SESSION['error'] = $this->upload_errors[$file['error']];
				return false;
			}
		}










		private function details( $file,$new_file_name= NULL,$target){//2
			if($new_file_name != NULL){
				$this->filename = $new_file_name;
				}else{
					$this->filename   = basename($file['name']);
				}
				
				  $this->temp_path  = $file['tmp_name'];
				  $this->type       = $file['type'];
				  $this->size       = $file['size'];
				  
				   if(empty($this->filename) || empty($this->temp_path)) {
						  $_SESSION['error'] = "The location to save the picture is not available. Contact Admin";
						  return false;
					
					  }
					 $this->ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
					  $this->pic_file = $this->target . $this->file_name. "." .$this->ext;
					 if (( strtolower($this->ext) != "jpg") && ( strtolower($this->ext) != "jpeg")&& ( strtolower($this->ext) != "png") 
					 && ( strtolower($this->ext) != "gif")
					  && ( strtolower($this->ext) != "psd") )
								{
									
										$_SESSION['error'] = "Invalid picture ";
										$this->error = 'error';
										return false;
									
								 }
			
			}

	
	
			public function saveMultiple($files,$path) {
	 
				// defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
			   //  prefix|_time_user_id_rand
				$pictures =[];
		   
		   
					$count = count($files['name']) - 1;
					 
					for($i = 0; $i < $count; $i++){
						
						if($files['size'][$i] > 0){
							
							$ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
		   
							if(in_array($ext, $this->extensions)){
								$temp_path = $files['tmp_name'][$i];
		   
								$picture_name = $this->name($i) . ".$ext";
								$target = $path . $picture_name;
							   if(move_uploaded_file($temp_path ,$target)) {
									 $pictures[] = $picture_name;
								   
								}else{
									
								}
							 }
						   
		   
						 }
						
					}
		   
		   
		   return $pictures;
		   
		   }
		   




		   public function name($index = 1){
			$name = uniqid().time();
			if(in_array($name,$this->name_array)){
				$this->name();
			}else{
				$this->name_array[] = $name;
			}
	   
	   return $name;
	   }
	
		// Pass in $_FILE(['uploaded_file']) as an argument
  public function save($file,$new_file_name =NULL,$target) {
	 
	 defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

	
		 $this->pic = $file;
		$this->file_name = $new_file_name;
		$this->target = $target;
	  
	  		$this->check_for_error($this->pic);
			if(!empty($this->error) && $this->error !=NULL){
				$_SESSION['error'] = $this->error;
				return false;
			}
			$this->details($this->pic,$this->file_name,$this->target);
			if(!empty($this->error) && $this->error !=NULL){
				//$_SESSION['error'] = $this->error;
				
			}
			
				// print_r($this->temp_path);
				// echo "<br>";
			if(move_uploaded_file($this->temp_path,$this->pic_file)) {
		  	//
			 
					unset($this->temp_path );
					return $this->pic_file;
			
			} else {
				
				// File was not moved.
		     $_SESSION['error'] = "Failed to Save image. Pls Try Again";
			 return false;
		    
			}
		}
	





	
	
	public function destroy() { 
		// First remove the database entry
		if($this->delete()) {
			// then remove the file
		  // Note that even though the database entry is gone, this object 
			// is still around (which lets us use $this->image_path()).
			$target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();
			return unlink($target_path) ? true : false;
		} else {
			// database delete failed
			return false;
		}
	}

	public function image_path() {
	  return $this->upload_dir.DS.$this->filename;
	}
	
	/*public function size_as_text() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}
	
	
*/


}



?>