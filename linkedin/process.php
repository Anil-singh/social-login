<?php

include_once("linkedin/config.php");
include_once("linkedin/http.php");
include_once("linkedin/oauth_client.php");
$client = new oauth_client_class;

$client->debug = false;
$client->debug_http = true;
$client->redirect_uri = $callbackURL;

$client->client_id = $linkedinApiKey;
$application_line = __LINE__;
$client->client_secret = $linkedinApiSecret;

if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
  die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
      'create an application, and in the line '.$application_line.
      ' set the client_id to Consumer key and client_secret with Consumer secret. '.
      'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
      'necessary permissions to execute the API calls your application needs.';

/* API permissions
 */
$client->scope = $linkedinScope;
if (($success = $client->Initialize())) {
  if (($success = $client->Process())) {
    if (strlen($client->authorization_error)) {
      $client->error = $client->authorization_error;
      $success = false;
    } elseif (strlen($client->access_token)) {
      $success = $client->CallAPI(
          'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
          'GET', array(
            'format'=>'json'
          ), array('FailOnAccessError'=>true), $user);

       $user_profile = (array)$user;

       $_SESSION = array();
        unset($_SESSION);
        session_destroy();

    }
   
  }

  $success = $client->Finalize($success);

}
?>

