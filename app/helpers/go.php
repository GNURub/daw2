<?php
class GoogleLogin
{
  private $go, $helper, $permissions;
  function __construct()
  {
    $this->go = new Google_Client();
    $this->go->setClientId(GOOGLE_ID);
    $this->go->setClientSecret(GOOGLE_SECRET);
    $this->go->setRedirectUri('https://thecatlong-gnurub.rhcloud.com/home/go');
    $this->go->addScope("email");
    $this->go->addScope("profile");
    $this->helper = new Google_Service_Oauth2($this->go);
  }
  function getUrl(){
    $loginUrl = $this->go->createAuthUrl();
    return htmlspecialchars($loginUrl);
  }
}


 ?>
