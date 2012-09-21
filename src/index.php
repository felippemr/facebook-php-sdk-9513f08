<?php
    require_once 'facebook.php';
    
    $appId = '160032724121022'; //appid from facebook
    $secret = 'a8fa687e01d1eaa1c7b984223c764490'; //secret from facebook
    $groupId = '130411277057132'; //facebook groupid
    
    $facebook = new Facebook(array(
      'appId'  => $appId,
      'secret' => $secret,
      'cookie' => true,
    ));
	
	$user = $facebook->getUser();
if ($user)
{
$logoutUrl = $facebook->getLogoutUrl();
try 
{
$userdata = $facebook->api('/me');
} 
catch (FacebookApiException $e) {
error_log($e);
$user = null;
}
$_SESSION['facebook']=$_SESSION;
$_SESSION['userdata'] = $userdata;
$_SESSION['logout'] = $logoutUrl;
//Redirecting to home.php
header("Location: home.php"); 
}
else
{ 
$loginUrl = $facebook->getLoginUrl(array(
 'scope' => 'email,user_birthday'
));
echo '<a href="'.$loginUrl.'">Login with Facebook</a>';
}
    
    $response = $facebook->api('/'.$groupId.'/feed', array('limit' => 6, 'fields'=>'from,message,created_time'));    
    print "<div class='facebook-feed-title'>Facebook Feed</div>";
    foreach ($response['data'] as $value) {
        print "<div class='facebook-from'><a href='http://www.facebook.com/home.php?#!/profile.php?id=".$value['from']['id']."'>".$value['from']['name']."</a> wrote:</div>";
        print "<div class='facebook-message'>".$value['message']."</div>";
        
    }
?>