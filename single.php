<?php require_once "includes/header.php" ;
$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id = :id";
            $details = query($sql,array(
                  'id'=>$id))->fetch(PDO::FETCH_OBJ);

  $sql2 = "SELECT * FROM post_gallery WHERE post_id = :id";
  $result = query($sql2,array(
        'id'=>$id))->fetch(PDO::FETCH_OBJ)
?>
    
    
    <div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('uploads/products<?php echo $result->path ?>');">
      <div class="container">
        <div class="row same-height justify-content-center">
          <div class="col-md-12 col-lg-10">
            <div class="post-entry text-center">
             
              <h1 class="mb-4"><a href="#"><?php echo $details->title?></a></h1>
              <div class="post-meta align-items-center text-center"> 
                <span class="d-inline-block mt-1">By <?php echo $details->author?></span>
                <span>&nbsp;-&nbsp; <?php echo $details->date?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <section class="site-section py-lg">
      <div class="container">
        
        <div class="row blog-entries element-animate">

          <div class="col-md-12 col-lg-12 main-content">
            
            <div class="post-content-body">
            <p>
            <?php echo $details->content?>
            </p>
            </div>

           


            

               

              


                     
          
              
            
            </div>

          </div>

          

        </div>
      </div>
    </section>

   


    
    
    
  <?php require_once "includes/footer.php" ?>