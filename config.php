<?php
	/*============Start - Social Media credentials ================================================*/
	define('FACEBOOK_APP_ID','');
	define('FACEBOOK_APP_SECRET','');
    define('TWITTER_APP_ID','');
    define('TWITTER_APP_SECRET','');
    define('TWITTER_CALLBACK_URL','http://127.0.0.1/social_login/twitter.php');
    define('GOOGLE_APP_ID','');
    define('GOOGLE_APP_SECRET','');
    define('LINKEDIN_APP_ID',''); // Linkedin app id
    define('LINKEDIN_APP_SECRET',''); // Linkedin app secret
    define('LINKEDIN_BASE_URL','http://localhost/social_login/login.php'); // Linkedin app base url
    define('LINKEDIN_CALLBACK_URL','http://localhost/social_login/linkedin.php'); // Linkedin call back url
    define('LINKEDIN_SCOPE','r_basicprofile r_emailaddress'); // Linkedin data access scope;
	/*============End - Social Media credentials ===================================================*/

	/*============Start - Including db setting configurations file =============================*/
	include_once('db_config.php');
	/*============End - Including db setting configurations file ===============================*/