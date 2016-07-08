<?php
    session_start();
    include_once 'config.php';
    require_once 'facebook/inc/facebook.php';
    require_once 'user.class.php';
    function init(){
        $userDetails = array();
        $facebook = new Facebook(array(
          'appId'  => FACEBOOK_APP_ID, 
          'secret' => FACEBOOK_APP_SECRET
        ));
        $user = $facebook->getUser();  
        if ($user) {
          try {
            $_fb['user'] = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture,birthday');
            $facebook->destroySession();
          } catch (FacebookApiException $e) {
            error_log($e);
            $_fb['user'] = null;
          }
        }
        if ($user) 
        {
            $_fb['logouturl'] = $facebook->getLogoutUrl();
            $_fb['authed'] = true;
            $userDetails = $_fb['user'];
        } 
        else 
        {
            $fbLoginUrl = $facebook->getLoginUrl(array('scope' => 'email'));
            header('location:'.$fbLoginUrl);
        }
        return $userDetails;
    }
    $userDetails = init();
    if(!empty($userDetails)){
        $table_name = "users";
        $first_name = isset($userDetails['first_name']) ? $userDetails['first_name'] : "";
        $last_name  = isset($userDetails['last_name']) ? $userDetails['last_name'] : "";
        $email      = isset($userDetails['email']) ? $userDetails['email'] : "";
        $gender     = isset($userDetails['gender']) ? $userDetails['gender'] : "";
        $pictureUrl = "";
        if(isset($userDetails['picture'])){
            if(isset($userDetails['picture']['data']))
                $pictureUrl = isset($userDetails['picture']['data']['url']) ? $userDetails['picture']['data']['url'] : "";
        }
        if($gender == "female"){
            $gender = 0; //female
        }
        else if($gender == "male"){
            $gender = 1; //female
        }
        else{
            $gender = 2; //other
        }
        /* Initiating user class */
        $obj_user = new User();
        /* Checking if user already exist in system and getting user details */
        $arr = $obj_user->getUser($email);
        if(!empty($arr)){
            $_SESSION['user_name']    = $arr[0]['first_name']." ".$arr[0]['last_name'];
            $_SESSION['user_email']   = $email;
            $_SESSION['user_img_url'] = $pictureUrl;
            header("Location:index.php");
            exit;
        }
        /* Adding new user details in database */
        $result = $obj_user->addUser($first_name,$last_name,$email,$gender);
        if($result){
            $_SESSION['user'] = $first_name." ".$last_name;
            header("Location:index.php");
        }
        else{
            echo 'User registration failed';
        }
    }
?>