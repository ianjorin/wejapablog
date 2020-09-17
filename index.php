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
          <div class="col-12 d-flex">
            <h2>Recent Posts</h2>

            <form class="form-inline src-form" action="processors/search.php" method="POST">
              <input class="form-control src mr-sm-2" name="name" id="searchBox" type="text" oninput=search(this.value) placeholder="Search Here..." aria-label="Search" autofocus>
              
              
            </form>
          </div>
        </div>

        <div class="row" id="dataViewer">
          <?php 
            foreach($title as $id => $name) {
              $rid = $name[4];

            $sql = "SELECT * FROM post_gallery WHERE post_id = :id";
            $details = query($sql,array(
                  'id'=>$rid))->fetch(PDO::FETCH_OBJ);

            echo "<div class='col-lg-4 mb-4'>";
            echo "<div class='entry2'>";
            echo "<a href='single?id=$name[4]'> <img src='uploads/products$details->path' alt='Image' class='img-fluid rounded;'></a>";
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
         


        
          
         
        </div>
        
      </div>
    </div>

  
   <?php require_once "includes/footer.php" ?>

   <script>
     function search(name){
       console.log(name);
       fetchSearchData(name);
     }

     function fetchSearchData(name){
       fetch('processors/search.php',{
         method:'POST',
         //body: JSON.stringify("name": name),
         body: new URLSearchParams('name=' +name),
        //  headers: {
        //     "Content-Type": "application/json"
        //   }
       })
       .then(res => res.json())
       .then(res => console.log(res))
       .then(res => console.error('Error: ' + e))
     }

     function viewSearchResult(data){
       const dataViewer = document.getElementById('dataViewer');

       dataViewer.innerHTML = " ";
     }
   </script>