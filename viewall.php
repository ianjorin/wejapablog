<?php require_once "includes/header.php";
 
 global $database;

 if(isset($_SESSION['user_id']))
{

$id = $_SESSION['user_id'];
 $sql = "SELECT * FROM posts
 WHERE  deleted = 0 AND userid = $id   ORDER BY date DESC";
 $result = $database->prepare($sql);
 $result->execute();
}

?>

<div class="site-section">
  <div class="container">
      <div class="mb-3">
     
      <!-- <form class="form-inline src-form" action="processors/search.php" method="POST">
         <input class="form-control src mr-sm-2" name="name" id="searchBox" type="text" oninput=search(this.value) placeholder="Search Here..." aria-label="Search" autofocus>
      </form> -->
      </div>
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
       <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Author</th>
                    <th scope="col">title</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($result->rowCount()>0) {
                    $i = 1;
                    while($data = $result->fetch(PDO::FETCH_OBJ)){

                    echo "<tr>";
                    echo  "<th scope='row'>$i</th>";
                    echo "<td>$data->author</td>";
                    echo "<td>$data->title </td>";
                    echo "<td> <a href='edit-post?id=$data->id'><button type='button' class='btn btn-outline-success'>Edit</button><a>";
                    echo "<button  type='button' data-id='$data->id' class='btn delete btn-outline-danger'>Delete</button></td>";
                    echo "</tr>";
                    $i++;

                    }
                }
                    ?>
                    

                    
                  
                </tbody>
            </table>

           
       </div>
    </div> 
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<?php require_once "includes/footer.php" ?>


<script src="js/main2.js"></script>


<script>

$('.delete').click(function(e) {
		
		var id = $(this).attr('data-id');
		
        if(confirm("Are you sure you wish to delete the post ")) 
	 {
        window.location = 'processors/delete-post.php?id='+id;
     }			
		
				
			
        
    });
</script>

