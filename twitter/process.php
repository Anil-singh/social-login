<?php
include_once 'config.php';
include_once("inc/twitteroauth.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if( isset($_REQUEST['oauth_token']) && isset($_SESSION['token'])) {	
	//Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
	$connection = new TwitterOAuth(TWITTER_APP_ID, TWITTER_APP_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	if($connection->http_code == '200')
	{
		//Redirect user to twitter
		//Insert user into the database
		$user_profile = (array)$connection->get('account/verify_credentials'); 
		$name = explode(" ",$user_profile['name']);
		$fname = "";
		$fname = "";
		if(count($name)>0)
			$fname = isset($name[0])?$name[0]:'';
		if(count($name)>1)
			$lname = isset($name[1])?$name[1]:'';		
		$user_profile['fname'] = $fname;
		$user_profile['lname'] = $lname;
                //$_SESSION['user'] = $user_profile;
        }

}else{
	
	//Fresh authentication
	$connection = new TwitterOAuth(TWITTER_APP_ID, TWITTER_APP_SECRET);
	$request_token = $connection->getRequestToken(TWITTER_CALLBACK_URL);	
	//Received token info from twitter

	$_SESSION['token'] 			= $request_token['oauth_token'];
	$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
	
	//Any value other than 200 is failure, so continue only if http code is 200
	if($connection->http_code == '200')
	{
		//redirect user to twitter
		$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);		
		header('Location: ' . $twitter_url); 
	}
        //var_dump($connection);
}
?>

