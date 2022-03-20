<!DOCTYPE html>
<html class="lightTheme">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Register</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  </head>
  <body>
		<form id="loginform" method="POST" >

			<h1>Sign up:</h1>
      <div id="registercontainer">
      <div id="userdetails">
      <div id="posdiv">
			  <p>Username:</p>
			  <input type="text" name="username" id="username" autocomplete="off" maxlength="15" placeholder="username"  required />
      </div>

			<p>Password:</p>
      <div id="posdiv">
		  	<input type="password" name="password" id="password" autocomplete="off" minlength="6" placeholder="password"  required />
         <p class="smltxt" id="pastrength"></p>
      </div>

			<p>Confirm Password:</p>
      <div id="posdiv">
        <input type="password" id="passconfirm" autocomplete="off" maxlength="15" placeholder="confirm..." required />
        <p class="smltxt" id="passptag"></p>
      </div>

      <?php

        if (isset($_POST["username"])){

            include "../phpscripts/db_connect.php";
            include "../phpscripts/registercode.php";
        }

      ?>
      </div>

      <div id='studentclasses'>
        <p>Class 1:</p>
        <input type="text" placeholder="Enter a class you take..." autocomplete = "off" maxlength=7 name="class1" id="class1" required />
        <p>Class 2:</p>
        <input type="text" placeholder="Enter a class you take..." autocomplete = "off" maxlength=7 name="class2" id="class2" required />
        <p>Class 3:</p>
        <input type="text" placeholder="Enter a class you take..." autocomplete = "off" maxlength=7 name="class3" id="class3" required />
        <p>Class 4 (optional):</p>
        <input type="text" placeholder="Enter a class you take..." autocomplete = "off" maxlength=7 name="class4" id="class4" />
      </div>
      </div>

			<br>	
            <button type="submit" id="submitbutton" class="submitbutton">Register!</button>
    </form>

    <script src="scripts/reg.js"></script>
    <script src="scripts/script.js"></script>
  </body>
</html>