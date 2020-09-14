<?php require_once "includes/header.php"?>

<link rel="stylesheet" href="css/mystyle.css">

<body class="text-center">
    <form class="form-signin" action="processors/login.php">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
      <span>Dont have an account?<a href="signup">Sign up</a></span>
      <div class="checkbox mb-3">
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; Anjorin Israel Wejapa 2020</p>
    </form>
</body>

