## Social Login 
        Social login contains sample code in php to enable a user login and registration from social media 
        sites Facebook,Linkedin,Twitter,Google.

## Example - Code Sample
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
	
### Login with Linkedin

    /* Initiating linkedin pauth class */
    $client = new oauth_client_class;

    /* Intialing oauth_client_class config variable */
    $client->debug = false;
    $client->debug_http = true;    
    $client->redirect_uri = $callbackURL;
    $client->client_id = $linkedinApiKey;
    $application_line = __LINE__;
    $client->client_secret = $linkedinApiSecret;

    /* Checking for client id */
    if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
    die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
      'create an application, and in the line '.$application_line.
      ' set the client_id to Consumer key and client_secret with Consumer secret. '.
      'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
      'necessary permissions to execute the API calls your application needs.';
    /* API permissions */

    /*Adding app data access scope */
    $client->scope = $linkedinScope;

    /*Initializing client */
    if (($success = $client->Initialize())) {        
      /* User authentcation process*/  
      if (($success = $client->Process())) {
        if (strlen($client->authorization_error)) {
          $client->error = $client->authorization_error;
          $success = false;
        } elseif (strlen($client->access_token)) {
          // Linkedin userdata api call
          $success = $client->CallAPI(
              'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
              'GET', array(
                'format'=>'json'
              ), array('FailOnAccessError'=>true), $user);
           $user_profile = (array)$user;          
        }       
      }
      $success = $client->Finalize($success);
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
    /*============Start - Social media credentials ================================================*/
    define('FACEBOOK_APP_ID','xxxxxxxxxxxx'); // Facebook app id 
    define('FACEBOOK_APP_SECRET','xxxxxxxxxxxxxxx'); // Facebook app secret
    define('TWITTER_APP_ID','xxxxxxxxxxxx'); // Twitter app id
    define('TWITTER_APP_SECRET','xxxxxxxxxxxxxxx'); // Twitter app secret
    define('TWITTER_CALLBACK_URL','Call back url'); // Twitter callback URL
    define('GOOGLE_APP_ID','xxxxxxxxxxxx'); // Google app id
    define('GOOGLE_APP_SECRET','xxxxxxxxxxxxxxx'); // Google secret
    define('LINKEDIN_APP_ID',''); // Linkedin app id
    define('LINKEDIN_APP_SECRET',''); // Linkedin app secret
    define('LINKEDIN_BASE_URL',''); // Linkedin app base url
    define('LINKEDIN_CALLBACK_URL',''); // Linkedin call back url
    define('LINKEDIN_SCOPE','r_basicprofile r_emailaddress'); // Linkedin data access scope;
    /*============End - Social media credentials  ===================================================*/

## API Reference
    1. Facebook PHP sdk from Facebook.
    2. Twitter PHP sdk from Twitter.
    3. Google PHP sdk from Google.
    4. LinkedIn PHP sdk from LinkedIn.

