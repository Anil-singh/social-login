<?php
	//Checking whether session exist or not
	if (session_status() == PHP_SESSION_NONE) {
		//Sarting session
	    session_start();
	}
	if(isset($_SESSION['user_email'])){
		$username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "";
		if(isset($_SESSION['user_img_url']))
			echo "<img src='".$_SESSION['user_img_url']."'><br>";
		echo "Hello ! $username <br><a href= logout.php>Click here to logout</a>";

	} else {
		// Redirecting to facebook login page if user is not loggedin
	    header("Location:login.php");
	}