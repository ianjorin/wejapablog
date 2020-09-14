<?php require_once "includes/header.php";
$id = $_GET['id'];


if(!ctype_digit($id) || empty($id) || !$_SERVER['HTTP_REFERER']){
    go('index');
}


$sql = "SELECT * FROM posts WHERE id = :id";
$details = query($sql,array(
    'id'=>$id))->fetch(PDO::FETCH_OBJ);



?>

<div class="site-section">
  <div class="container">
      <div class="row">
      <div class="col-lg-3">
            <div class="card text-black" style="width: 18rem;">
                <div class="card-header">
                    Dashboard
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="admin">Add Blog Post</a></li>
                    <li class="list-group-item"><a href="viewall">View all Blog Post</a></li>
                </ul>
            </div>
       </div>
       <div class="col-lg-9">
        <div>
          <?php alert() ?>
        </div>
            <form action="processors/update-post.php" method="post" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name of Author</label>
                        <input type="text" value="<?php echo $details->author ?>" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Full Name of Author">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Title of Post</label>
                        <input type="text" name="title" value="<?php echo $details->title?>" class="form-control" id="exampleFormControlInput1" placeholder="Title of Post ">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Main Content of Post</label>
                        <textarea class="form-control"  name="content" id="exampleFormControlTextarea1" rows="3"><?php echo $details->content?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Image</label>
                        <input type="file" name="main_picture" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                   
                    <div class = "form-group">
                    <button name="save" class="form-control btn-success">Update</button>

                    </div>

                    <input type="hidden" name="id" value="<?= $id?>">
                </form>

       </div>
    </div> 
  </div>
</div>



<?php require_once "includes/footer.php" ?>

<script src="ckeditor/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content');
</script>
