<?php
class GoogleLogin
{
  protected $go, $helper, $permissions;
  function __construct()
  {
    $this->go = new Google_Client();
    $this->go->setClientId(GOOGLE_ID);
    $this->go->setClientSecret(GOOGLE_SECRET);
    $this->go->setRedirectUri('https://thecatlong-gnurub.rhcloud.com/home/go');
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
    if (! isset($accessToken)) {
      if ($this->helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        // echo "Error: " . $this->helper->getError() . "\n";
        // echo "Error Code: " . $this->helper->getErrorCode() . "\n";
        // echo "Error Reason: " . $this->helper->getErrorReason() . "\n";
        // echo "Error Description: " . $this->helper->getErrorDescription() . "\n";
        return array("error"=> 401, "user"=>null);
      } else {
        // header('HTTP/1.0 400 Bad Request');
        // echo 'Bad request';
        return array("error"=> 400, "user"=>null);
      }
    }else{
      $userinfo = $plus->userinfo;
      print_r($userinfo->get());
      exit;
      return array("error"=> null, "user"=>$userinfo->get());
    }

  }
}


 ?>
