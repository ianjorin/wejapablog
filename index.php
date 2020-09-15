<?php require_once "includes/header.php";

$del = 0;

$sql = "SELECT * FROM posts WHERE  deleted = :del ORDER BY date DESC";
$detail = query($sql, ['del' => $del]);
$title = [];

foreach($detail as $row) {

        $title[$row['id']] = [$row['author'], $row['title'],$row['date'],$row['content'],$row['id']];
}

 ?>
    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-12">
            <h2>Recent Posts</h2>
          </div>
        </div>
        <div class="row">
          <?php 
            foreach($title as $id => $name) {
              $rid = $name[4];

            $sql = "SELECT * FROM post_gallery WHERE post_id = :id";
            $details = query($sql,array(
                  'id'=>$rid))->fetch(PDO::FETCH_OBJ);

            echo "<div class='col-lg-4 mb-4'>";
            echo "<div class='entry2'>";
            echo "<a href='single?id=$name[4]'> <img src='uploads/products$details->path' alt='Image' height="370px" width="207px" class='img-fluid rounded;'></a>";
            echo "<div class='excerpt'>";
            echo "<h2><a href='single?id=$name[4]'>$name[1]</a></h2>";
            echo "<div class='post-meta align-items-center text-left clearfix'>";
            echo "<span class='d-inline-block mt-1'>By <a href='#'>$name[0]</a></span>";
            echo "<span>&nbsp;-&nbsp;$name[2] </span>";
            echo "</div>";
              
            echo "<p>";
            $string = $name[3];
            $string = strip_tags($string);
            $string = trim($string);
            echo substr($string, 0, 150);
            echo  "</p>";
            echo "<p><a href='single?id=$name[4]'>Read More</a></p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            }
          ?>
          <!-- <div class="col-lg-4 mb-4">
            <div class="entry2">
              <a href="single.html"><img src="images/img1.jpg" alt="Image" class="img-fluid rounded"></a>
              <div class="excerpt">
              <h2><a href="single.html">Improving as a young PHP  Developer.</a></h2>
              <div class="post-meta align-items-center text-left clearfix">
                <span class="d-inline-block mt-1">By <a href="#">Anjorin Israel</a></span>
                <span>&nbsp;-&nbsp; July 19, 2019</span>
              </div>
              
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta beatae quia porro id est.</p>
                <p><a href="single">Read More</a></p>
              </div>
            </div>
          </div> -->
          <!-- <div class="col-lg-4 mb-4">
            <div class="entry2">
              <a href="single.html"><img src="images/img1.jpg" alt="Image" class="img-fluid rounded"></a>
              <div class="excerpt">

              <h2><a href="single.html">Understanding SQL and writing queries</a></h2>
              <div class="post-meta align-items-center text-left clearfix">
                
                <span class="d-inline-block mt-1">By <a href="#">Anjorin Israel</a></span>
                <span>&nbsp;-&nbsp; July 19, 2019</span>
              </div>
              
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta beatae quia porro id est.</p>
                <p><a href="#">Read More</a></p>
              </div>
            </div> -->
          <!-- </div>
          <div class="col-lg-4 mb-4">
            <div class="entry2">
              <a href="single.html"><img src="images/img1.jpg" alt="Image" class="img-fluid rounded"></a>
              <div class="excerpt">
              <h2><a href="single.html">Understanding SQL and writing queries</a></h2>
              <div class="post-meta align-items-center text-left clearfix">
               
                <span class="d-inline-block mt-1">By <a href="#">Anjorin Israel</a></span>
                <span>&nbsp;-&nbsp; July 19, 2019</span>
              </div>
              
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta beatae quia porro id est.</p>
                <p><a href="#">Read More</a></p>
              </div>
            </div>
          </div> -->


        
          
         
        </div>
        
      </div>
    </div>

  
   <?php require_once "includes/footer.php" ?>
