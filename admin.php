<?php require_once "includes/header.php" ?>

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
            <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name of Author</label>
                        <input type="text" name="user" class="form-control" id="exampleFormControlInput1" placeholder="Full Name of Author">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Title of Post</label>
                        <input type="text" name="user" class="form-control" id="exampleFormControlInput1" placeholder="Title of Post ">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Main Content of Post</label>
                        <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Image</label>
                        <input type="file" name="path" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Date</label>
                        <input type="date" name="date" class="form-control" id="exampleFormControlInput1" placeholder="Title of Post ">
                    </div>
                </form>

       </div>
    </div> 
  </div>
</div>



<?php require_once "includes/footer.php" ?>
