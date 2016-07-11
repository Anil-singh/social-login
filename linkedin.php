<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('linkedin/process.php');
$user_profile = isset($user_profile) ? $user_profile : "";
    if($user_profile == ""){
        echo "Some error occured while registering";
        exit;
    }
    $first_name = isset($user_profile['firstName']) ? $user_profile['firstName'] : "";
    $last_name = isset($user_profile['lastName']) ? $user_profile['lastName'] : "";
    
    $email = isset($user_profile['emailAddress']) ? $user_profile['emailAddress'] : "";
    $gender = isset($user_profile['gender']) ? $user_profile['gender'] : 2;
    /* Initiating user class */
    $obj_user = new User();
    /* Checking if user already exist in system and getting user details */
    $arr = $obj_user->getUser($email);
    if(empty($arr)){ //Record does not exist,insert to DB, set session and redirect to index.php
        $result = $obj_user->addUser($first_name,$last_name,$email,$gender);
        if(!$result){
           echo 'Some error occurred while inserting to Database!';
           exit;
        }
    }
    $_SESSION['user_name'] = $first_name." ".$last_name;
    header("Location:index.php");
    exit;
?>