<?php	
	include_once '../config.php';
        include_once("src/Google_Client.php");
	include_once("src/contrib/Google_Oauth2Service.php");
	######### edit details ##########
	$clientId = GOOGLE_APP_ID; //Google CLIENT ID
	$clientSecret = GOOGLE_APP_SECRET; //Google CLIENT SECRET
	$redirectUrl = 'http://localhost/social_login/google.php';  //return url (url to script)
	$homeUrl = 'http://localhost/social_login/index.php';  //return to home

	##################################

	$gClient = new Google_Client();
	$gClient->setApplicationName('');//Set your application name here
	$gClient->setClientId($clientId);
	$gClient->setClientSecret($clientSecret);
	$gClient->setRedirectUri($redirectUrl);
	$gClient->setApprovalPrompt('auto');
	$google_oauthV2 = new Google_Oauth2Service($gClient);
?>