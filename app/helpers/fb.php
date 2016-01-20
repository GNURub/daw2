<?php

class FacebookLogin
{
  private $fb, $permissions;
  private static $helper;
  function __construct($permissions = array('email'))
  {
    $this->permissions = $permissions;
    $this->fb = new Facebook\Facebook([
      'app_id' => FACEBOOK_ID,
      'app_secret' => FACEBOOK_SECRET,
      'default_graph_version' => 'v2.5',
    ]);
    self::$helper = $this->fb->getRedirectLoginHelper();
  }

  function getUrl($fbUrl = 'https://thecatlong-gnurub.rhcloud.com/home/fb'){
    $loginUrl = self::$helper->getLoginUrl($fbUrl, $this->permissions);
    return htmlspecialchars($loginUrl);
  }

  function getToken(){
    // try {
    //   $accessToken = self::$helper->getAccessToken();
    // } catch(Facebook\Exceptions\FacebookResponseException $e) {
    //   // When Graph returns an error
    //   echo 'Graph returned an error: ' . $e->getMessage();
    //   exit;
    // } catch(Facebook\Exceptions\FacebookSDKException $e) {
    //   // When validation fails or other local issues
    //   echo 'Facebook SDK returned an error: ' . $e->getMessage();
    //   exit;
    // }

    // if (! isset($accessToken)) {
    //   if (self::$helper->getError()) {
    //     header('HTTP/1.0 401 Unauthorized');
    //     echo "Error: " . self::$helper->getError() . "\n";
    //     echo "Error Code: " . self::$helper->getErrorCode() . "\n";
    //     echo "Error Reason: " . self::$helper->getErrorReason() . "\n";
    //     echo "Error Description: " . self::$helper->getErrorDescription() . "\n";
    //   } else {
    //     header('HTTP/1.0 400 Bad Request');
    //     echo 'Bad request';
    //   }
    //   exit;
    // }

  //   // Logged in
  //   echo '<h3>Access Token</h3>';
  //   var_dump($accessToken->getValue());
  //
  //   // The OAuth 2.0 client handler helps us manage access tokens
  //   $oAuth2Client = $this->fb->getOAuth2Client();
  //
  //   // Get the access token metadata from /debug_token
  //   $tokenMetadata = $oAuth2Client->debugToken($accessToken);
  //   echo '<h3>Metadata</h3>';
  //   var_dump($tokenMetadata);
  //
  //   // Validation (these will throw FacebookSDKException's when they fail)
  //   $tokenMetadata->validateAppId($config['app_id']);
  //   // If you know the user ID this access token belongs to, you can validate it here
  //   //$tokenMetadata->validateUserId('123');
  //   $tokenMetadata->validateExpiration();
  //
  //   if (! $accessToken->isLongLived()) {
  //     // Exchanges a short-lived access token for a long-lived one
  //     try {
  //       $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  //     } catch (Facebook\Exceptions\FacebookSDKException $e) {
  //       echo "<p>Error getting long-lived access token: " . self::$helper->getMessage() . "</p>\n\n";
  //       exit;
  //     }
  //
  //     echo '<h3>Long-lived</h3>';
  //     var_dump($accessToken->getValue());
  //   }
  //
  //   $_SESSION['fb_access_token'] = (string) $accessToken;
  }
}

 ?>
