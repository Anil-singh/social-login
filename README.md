## Social Login 
        Social login contains sample code in php to enable a user login and registration from social media 
        sites Facebook,Linkedin,Twitter,Google.

## Example
### Login with Facebook
        //Intiating Facebook class
        $facebook = new Facebook(array(
          'appId'  => FACEBOOK_APP_ID, 
          'secret' => FACEBOOK_APP_SECRET
        ));

        //Getting facebook login url
        $fbLoginUrl = $facebook->getLoginUrl(array('scope' => 'email'));
        header('location:'.$fbLoginUrl);

        //Getting facebook user id to check user authentication in order to get user profile data.
        $user = $facebook->getUser(); 

        try {
            // Getting facebook user profile data
            $_fb['user'] = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture,birthday');
            // Destroying facebook user session 
            $facebook->destroySession();
        } catch (FacebookApiException $e) {            
            $_fb['user'] = null;
        }

        /* Initiating user class */
        $obj_user = new User();
        
        /* Checking if user already exist in system and getting user details */
        $arr = $obj_user->getUser($email);

        /* Adding new user details in database */
        $result = $obj_user->addUser($first_name,$last_name,$email,$gender);

### Login with Google
	$gClient = new Google_Client();
	$gClient->setApplicationName('');//Set your application name here
	$gClient->setClientId($clientId);
	$gClient->setClientSecret($clientSecret);
	$gClient->setRedirectUri($redirectUrl);
	$gClient->setApprovalPrompt('auto');
	$google_oauthV2 = new Google_Oauth2Service($gClient);
	$gClient->authenticate();
        if ($gClient->getAccessToken()) {
        	$user_profile = $google_oauthV2->userinfo->get();	
        	$gClient->revokeToken();
        } else {
        	$authUrl = $gClient->createAuthUrl();
        }
        
        $obj_user = new User();
        /* Checking if user already exist in system and getting user details */
        $arr = $obj_user->getUser($email);
        if(empty($arr)){ 
                //Record does not exist,insert to DB, set session and redirect to index.php
                $result = $obj_user->addUser($first_name,$last_name,$email,$gender);
        }
### Login with Twitter

	//redirect user to twitter
	$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);		
	header('Location: ' . $twitter_url); 
	
	//Fresh authentication
	$connection = new TwitterOAuth(TWITTER_APP_ID, TWITTER_APP_SECRET);
	$request_token = $connection->getRequestToken(TWITTER_CALLBACK_URL);
	
	//Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
	$connection = new TwitterOAuth(TWITTER_APP_ID, TWITTER_APP_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	
	/* Initiating user class */
	$obj_user = new User();
	/* Checking if user already exist in system and getting user details */
	$arr = $obj_user->getUser($twitter_id,false);
	if(empty($arr)){ //Record does not exist,insert to DB, set session and redirect to index.php
		$result = $obj_user->addUser($first_name,$last_name,$email,$gender,$twitter_id);
	}
	
## Installation

### Dependecies
        PHP 5.5
        MySql 5.6.17

### Database - social_login.sql
    Need to create a database named social_login and improt social_login.sql file to that db.This db users table
    will store users profiles data from social media sites. 

### Database configurations - db_config.php
    Need to update following database details in db_config.php file.
    define ('DB_USER', "root"); // Database user name
    define ('DB_PASSWORD', ""); // Database password
    define ('DB_DATABASE', "social_login"); // Database name
    define ('DB_HOST', "host"); // Database host

### Social Media configurations - config.php
    /*============Start - Facebook credentials ================================================*/
    define('FACEBOOK_APP_ID','xxxxxxxxxxxx'); // Facebook app id 
    define('FACEBOOK_APP_SECRET','xxxxxxxxxxxxxxx'); // Facebook app secret
    /*============End - Facebook credentials ===================================================*/

## API Reference
    1. Facebook sdk for php from facebook.
