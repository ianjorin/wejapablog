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
                    <tr>
                    <th scope="row">1</th>
                    <td>Anjorin Israel</td>
                    <td>Improving as a young PHP  Developer </td>
                    <td><button type="button" class="btn btn-outline-success">Edit</button>
                    <button type="button" class="btn btn-outline-danger">Delete</button></td>
                    </tr>

                    <tr>
                    <th scope="row">2</th>
                    <td>Anjorin Israel</td>
                    <td>Understanding SQL and writing queries</td>
                    <td><button type="button" class="btn btn-outline-success">Edit</button>
                    <button type="button" class="btn btn-outline-danger">Delete</button></td>
                    </tr>
                  
                </tbody>
            </table>

           
       </div>
    </div> 
  </div>
</div>



<?php require_once "includes/footer.php" ?>
