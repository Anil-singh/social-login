<?php
include_once("google/config.php");
if(isset($_REQUEST['code'])){
	$gClient->authenticate();	
}

if ($gClient->getAccessToken()) {
	$user_profile = $google_oauthV2->userinfo->get();	
	$gClient->revokeToken();
} else {
	$authUrl = $gClient->createAuthUrl();

}

if(isset($authUrl)) {
	//echo '<a href="'.$authUrl.'"><img src="images/glogin.png" alt=""/></a>';
	?>
	<script>
	window.location.href = "<?php echo $authUrl; ?>";
	</script>
	<?php
} 

?>