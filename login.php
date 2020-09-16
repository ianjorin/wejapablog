<?php require_once "includes/header.php"?>

<link rel="stylesheet" href="css/mystyle.css">

<body class="text-center">

<
    <form class="form-signin" action="processors/log-in.php" method="post">
    <?php if(isset($_SESSION['error']) && !empty($_SESSION['error'])) { ?> 
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php } ?>
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
      <span>Dont have an account?<a href="signup">Sign up</a></span> <br>
      <span> <a href="enter-email">forgot password?</a></span>
      <div class="checkbox mb-3">
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; Anjorin Israel Wejapa 2020</p>
    </form>
</body>

