<!DOCTYPE html>
<html class="lightTheme">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Login page</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  </head>
  <body>
		<form id="loginform" method="POST">
			<h1>Log in:</h1>
			<p>Username:</p>
			<input type="text" name="username" id="username" autocomplete="off" maxlength="15" placeholder="username" required />
			<p>Password:</p>
			<input type="password" name="password" id="password" autocomplete="off" maxlength="15" placeholder="password" required />
			<br>	

      <?php
    
        if(isset($_POST["username"])){

          include "../phpscripts/db_connect.php";
          include "../phpscripts/logincode.php";

        }

      ?>

      <p>Don't have an account? Click <a href="register.php">here</a> to make one!</p>
      <button type="submit" id="submitbutton" class="submitbutton">Submit</button>		
      <button id="theme" onclick="toggleTheme()">Change theme!</button>

  </form>  


    <script src="scripts/script.js"></script>
  </body>
</html>