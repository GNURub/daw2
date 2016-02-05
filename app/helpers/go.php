<?php
class GoogleLogin
{
  private $go, $helper, $permissions;
  function __construct()
  {
    $this->go = new Google_Client();
    $this->go->setClientId(GOOGLE_ID);
    $this->go->setClientSecret(GOOGLE_SECRET);
    $this->go->setRedirectUri('https://thecatlong-gnurub.rhcloud.com/client/go');
    $this->go->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
    $this->helper = new Google_Service_Oauth2($this->go);
  }
  function getUrl(){
    $loginUrl = $this->go->createAuthUrl();
    return htmlspecialchars($loginUrl);
  }
  function getToken(){
    if (isset($_REQUEST['code'])) {
      $this->go->authenticate($_REQUEST['code']);
      $_SESSION['access_token_go'] = $this->go->getAccessToken();
    }
    if (isset($_SESSION['access_token_go'])) {
      $this->go->setAccessToken($_SESSION['access_token_go']);
    }
    try {
      $accessToken = $this->go->getAccessToken();
    } catch (Exception $e) {
      return array("error"=> $e->getMessage(), "user"=>null);
    }
    if (!isset($accessToken)) {
        return array("error"=> 400, "user"=>null);
    }
    $userinfo = $this->helper->userinfo;
    return array("error"=> null, "user"=>$userinfo->get());

  }
}


 ?>
