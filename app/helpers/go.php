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
    // $this->go->addScope("email");
    // $this->go->addScope("profile");
    $this->go->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
    $this->helper = new Google_Service_Oauth2($this->go);
  }
  function getUrl(){
    $loginUrl = $this->go->createAuthUrl();
    return htmlspecialchars($loginUrl);
  }
  function getToken(){
    try {
      $accessToken = $this->go->getAccessToken();
    } catch (Exception $e) {
      return array("error"=> $e->getMessage(), "user"=>null);
    }
    if (!isset($accessToken)) {
        return array("error"=> 400, "user"=>null);
    }else{
      $userinfo = $this->helper->userinfo;
      print_r($userinfo->get());
      exit;
      return array("error"=> null, "user"=>$userinfo->get());
    }

  }
}


 ?>
