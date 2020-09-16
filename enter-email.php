<?php require_once "includes/header.php"?>

<link rel="stylesheet" href="css/mystyle.css">

<body class="text-center">


    <form class="form-signin" action="processors/enter-email.php" method="post">
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
      <h1 class="h3 mb-3 font-weight-normal">Reset Password</h1>
      <label for="inputEmail" class="sr-only">Enter Email address</label>
      <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Reset</button>
      <p class="mt-5 mb-3 text-muted">&copy; Anjorin Israel Wejapa 2020</p>
    </form>
</body>

