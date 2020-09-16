<?php require_once "includes/header.php"?>

<link rel="stylesheet" href="css/mystyle.css">

<body class="text-center">


    <form class="form-signin" action="processors/log-in.php" method="post">
    
         <p>
			We sent an email to  <b><?php echo $_GET['email'] ?></b> to help you recover your account. 
		</p>
	    <p>Please login into your email account and click on the link we sent to reset your password</p>
    </form>
</body>

