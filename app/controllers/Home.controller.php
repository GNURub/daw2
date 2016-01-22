<?php

  class Home extends Controller
  {
      private $product;
      private $category;
      private $client;
      protected static $fb, $go;
      public function __construct()
      {
        $this->product  = new ProductModel();
        $this->client   = new ClientModel();
        $this->category = new CategoryModel();
        self::$fb = new FacebookLogin();
        self::$go = new GoogleLogin();

      }
      public function index()
      {
          // load VIEWSs
          $productos = $this->product->toArray();
          $currentUser = self::getSession('username');
          require VIEWS . 'home/index.php';
      }

      public function signinAction()
      {
          if (self::getSession('username')) {
            header('location: /');
            return;
          }

          // load VIEWSs
          $fbUrl = self::$fb->getUrl();
          $goUrl = self::$go->getUrl();
          require VIEWS . 'home/signin.php';
      }

      public function signupAction()
      {
          if (self::getSession('username')) {
            header('location: /');
            return;
          }
          // load VIEWSs
          require VIEWS . 'home/signup.php';
      }

      public function logoutAction()
      {
          self::destroySession('username');
          self::destroySession('admin');
          header('location: /home/signin');
      }

      public function lostAction()
      {
          // load VIEWSs

          require VIEWS . 'home/lost.php';

      }

      public function filosofyAction()
      {
          // load VIEWSs

          require VIEWS . 'home/lost.php';

      }

      public function multimediaAction()
      {
          // load VIEWSs
          $categories = array(array('idcategoria'=> 'Imagenes'), array('idcategoria'=>'Videos'));
          require VIEWS . 'home/lost.php';

      }

      


  }
?>
