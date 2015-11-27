<?php

  class Home extends Controller
  {
      private $product;
      private $category;
      private $client;
      public function __construct()
      {
        $this->product  = new ProductModel();
        $this->client   = new ClientModel();
        $this->category = new CategoryModel();

      }
      public function index()
      {
          // load VIEWSs
          require VIEWS . 'home/index.php';
      }

      public function signinAction()
      {
          if (self::getSession('username')) {
            header('location: /');
            return;
          }
          // load VIEWSs
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
          header('location: /home/signin');
      }

      public function lostAction()
      {
          // load VIEWSs

          require VIEWS . 'home/lost.php';

      }


  }
?>
