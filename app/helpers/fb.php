<?php

class FacebookLogin
{
  private $fb, $helper, $permissions;
  function __construct($permissions = array('email'))
  {
    $this->permissions = $permissions;
    $this->fb = new Facebook\Facebook([
      'app_id' => FACEBOOK_ID,
      'app_secret' => FACEBOOK_SECRET,
      'default_graph_version' => 'v2.5',
    ]);
    $this->helper = $this->fb->getRedirectLoginHelper();
  }

  function getUrl($fbUrl = 'https://thecatlong-gnurub.rhcloud.com/client/fb'){
    $params = array(
        'scope' => 'email,user_location, user_birthday',
    );
    $loginUrl = $this->helper->getLoginUrl($fbUrl, $params);
    return htmlspecialchars($loginUrl);
  }

  function getToken(){
    try {
      $accessToken = $this->helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      return array("error"=> $e->getMessage(), "user"=>null);
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      return array("error"=> $e->getMessage(), "user"=>null);
    }

    if (! isset($accessToken)) {
      if ($this->helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        return array("error"=> 401, "user"=>null);
      }
      return array("error"=> 400, "user"=>null);
    }

    $this->fb->setDefaultAccessToken($accessToken->getValue());

    $oAuth2Client = $this->fb->getOAuth2Client();

    try {
      $response = $this->fb->get('/me?locale=en_US&fields=name,email');
      $userNode = $response->getGraphUser();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      return array("error"=> $e->getMessage(), "user"=>null);
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      return array("error"=> $e->getMessage(), "user"=>null);
    }
    return array("error"=> null, "user"=>$userNode);
  }
}

 ?>
