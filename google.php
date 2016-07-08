<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    include 'config.php';
    include('google/index.php');
    require_once 'user.class.php';
    $user_profile = isset($user_profile) ? $user_profile : "";
    if($user_profile == ""){
        echo "Some error occured while registering this user";
        exit;
    }
    $first_name = $last_name = "";
    if(isset($user_profile['name'])){
        $name = explode(" ",$user_profile['name']);
        $first_name = isset($name[0]) ? $name[0] : "";
        $last_name = isset($name[1]) ? $name[1] : "";
    }
    $email = isset($user_profile['email']) ? $user_profile['email'] : "";
    $gender = isset($user_profile['gender']) ? $user_profile['gender'] : 2;
    /* Initiating user class */
    $obj_user = new User();
    /* Checking if user already exist in system and getting user details */
    $arr = $obj_user->getUser($email);
    if(empty($arr)){ //Record does not exist,insert to DB, set session and redirect to index.php
        $result = $obj_user->addUser($first_name,$last_name,$email,$gender);
        if($result){
           
        }
    }
    $_SESSION['user_name'] = $first_name." ".$last_name;
    header("Location:index.php");
    exit;
?>