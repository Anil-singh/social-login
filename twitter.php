<?php
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    include('twitter/process.php');
    require_once 'config.php';
    require_once 'user.class.php';
    $user_profile = isset($user_profile) ? $user_profile : "";
    if($user_profile == ""){
        echo "Some error occured while registering";
        exit;
    }
    $twitter_id = isset($user_profile['id']) ? $user_profile['id'] : "";
    $first_name = isset($user_profile['fname']) ? $user_profile['fname'] : "";
    $last_name = isset($user_profile['lname']) ? $user_profile['lname'] : "";
    $email = isset($user_profile['email']) ? $user_profile['email'] : "";
    $gender = isset($user_profile['gender']) ? $user_profile['gender'] : 2;
    /* Initiating user class */
    $obj_user = new User();
    /* Checking if user already exist in system and getting user details */
    $arr = $obj_user->getUser($twitter_id,false);
    if(empty($arr)){ //Record does not exist,insert to DB, set session and redirect to index.php
        $result = $obj_user->addUser($first_name,$last_name,$email,$gender,$twitter_id);
        if($result){
            header("Location:index.php");
        }
    }
    else{
        header("Location:index.php");
    }
    $_SESSION['user_name'] = $first_name." ".$last_name;
    $_SESSION['twitter_id'] = $twitter_id;
    //exit;
?>
