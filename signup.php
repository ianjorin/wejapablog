<?php require_once "includes/header.php"?>

<link rel="stylesheet" href="css/mystyle.css">

<body>
  
<div class="container">
<div class="form-container">
<div>
<?php if(isset($_SESSION['reg_error']) && !empty($_SESSION['reg_error'])) { ?> 
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php
    echo $_SESSION['reg_error'];
    unset($_SESSION['reg_error']);
    ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
</div>
<form action="processors/sign-up.php" method="post">
  <div class="form-row">
    
  <div class="form-group col-md-6">
      <label for="inputEmail4">Firstname</label>
      <input type="text" name="first_name" class="form-control" id="inputEmail4" required>
  </div>

    <div class="form-group col-md-6">
      <label for="inputPassword4">Lastname</label>
      <input type="text" name="last_name" class="form-control" id="inputPassword4" required>
    </div>

    <div class="form-group col-md-12">
      <label for="inputEmail4">Email</label>
      <input type="email" name="email" class="form-control" id="inputEmail4"  required>
    </div>

    <div class="form-group col-md-12">
      <label for="inputPassword4">Password</label>
      <input type="password" name="password" class="form-control" id="inputPassword4" required>
    </div>
 
 
  
  
    <div class="form-group col-md-12">
      <label for="inputZip">Phone</label>
      <input type="tel" name="phone" class="form-control" id="inputZip" required>
    </div>
  </div>
  
  <button type="submit" class="btn btn-primary">Sign Up</button>
  <p class="mt-5 mb-3 text-muted">&copy; Anjorin Israel Wejapa 2020</p>

</form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>   
</body>


<script>
$('.alert').alert('close')

</script>