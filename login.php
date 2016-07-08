<?php
    session_start();
    if(isset($_SESSION['twitter_id'])){
        header('Location:index.php');
    }
?>
<html>
    <head>
        <title>Login</title>
        <style>
            .center{
                position: relative;
                top: 50%;
                left: 50%;
                margin-left: -150px;
                margin-top: -23px;
            }
        </style>
        <link rel="stylesheet" href="assets/css/slide-social-buttons.css">
    </head>
    <div>
        Login using:<br><br>
    </div>
    <ul class="soc">
        <!-- Facebook -->
        <a href="facebook.php" class="slide-social">
           <div class="soc-facebook" href="#"></div>
        </a>
        <!-- Twitter -->
        <a href="twitter.php" class="slide-social">
            <div class="soc-twitter" href="#"></div> 
        </a>
        <!-- Google+ -->
        <a href="google.php" class="slide-social">
            <div class="soc-google" href="#"></div>
        </a>
    </ul>
</html>

