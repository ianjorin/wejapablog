<?php require_once "includes/header.php";

$token = $_GET['token'];
?>

<link rel="stylesheet" href="css/mystyle.css">

<body class="text-center">
    <form class="form-signin" action="processors/new-pass" method="post">
    <?php if(isset($_SESSION['reset_error']) && !empty($_SESSION['reset_error'])) { ?> 
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php
        echo $_SESSION['reset_error'];
        unset($_SESSION['reset_error']);
        ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php } ?>
      <h1 class="h3 mb-3 font-weight-normal">Reset Your Password</h1>
      <label for="inputEmail" class="sr-only">New Password</label>
      <input type="password" name="password" id="inputEmail" class="form-control" placeholder="Password" required autofocus>
      <label for="inputPassword" class="sr-only">Confirm Password</label>
      <input type="password" name="password_conf" id="inputPassword" class="form-control" placeholder=" Confirm Password" required>
      <input type="hidden" name="token" value = "<?= $token?>">
      <div class="checkbox mb-3">
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; Anjorin Israel Wejapa 2020</p>
    </form>
</body>

