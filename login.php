<?php
    session_start();
    /* Checking whether user is already loggedin */
    if(isset($_SESSION['user_email'])){
        /*Redirecting loggeding user to index page */
        header("location:index.php");
    }
?>
<html>
    <head>
        <title>Login</title>
        <style>
            .center{
                position: absolute;
                top: 50%;
                left: 50%;
                margin-left: -150px;
                margin-top: -23px;
            }
        </style>
    </head>
    <a href="facebook.php" title="Click here to login with facebook"><img class="center" src="assets/img/facebook.png"/></a>
</html>

