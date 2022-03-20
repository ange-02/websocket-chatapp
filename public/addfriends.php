<!DOCTYPE html>
<html lang="en">

<head>

    <?php 
        include '../phpscripts/db_connect.php';
        session_start();
        if ($_SESSION["username"]){
            setcookie("username", $_SESSION["username"]); 
            include '../phpscripts/populate_msg.php';
        } else {
            header('location: login.php');
        }
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a friend</title>
    <link href="homestyle.css" rel="stylesheet" type="text/css" />
    <script src="scripts/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


    <body>
        <a id="backfriends" href="index.php"> << Back </a>
        <div id="search">
            <h1 id="header">Search for people to add:</h1>

            <form id="searcher" method="GET">
                <input name="username" type="text" class="searchbar" placeholder="search for someone..." autocomplete="off" required/>
                <button type="submit" id="addfriend"><i class="fas fa-search"></i></button>
            </form>
        </div>

        </div>
            <div id="searchresults">
                <?php

                    include "../phpscripts/db_connect.php";
                    include "../phpscripts/friendsearch.php";

                ?>
            </div>
    </body>
</html>