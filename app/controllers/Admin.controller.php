<?php


  class Admin extends Controller {
      private $_params;
      private $product;
      private $category;
      private $clients;
      static $products;
      private $isAdmin;

      public function __construct($params = array())
      {
          $this->product    = new ProductModel();
          $this->clients    = new ClientModel();
          $this->category   = new CategoryModel();
          $this->_params    = $params;
          self::$products   = $this->product->toArray();
          $this->isAdmin    = (self::getSession('admin') == "admin" ||
                              self::getSession('admin') == "administrador");
      }

      public function index($params = array()){
          if(empty($params[0])){
            require VIEWS . 'error/404.php';
          }else{
            header('location: /');
          }
          return;
      }

      public function notifyAction()
      {
        if($this->isAdmin){
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            extract($_POST);
            $clientes = $this->clients->toArray();
            function send_email($user){
              mail($user['email'], $title, $etalles);
              sleep(20);
            }
            foreach ($clientes as $value) {
              send_email($value);
            }
            return;
          }
          return require VIEWS . 'admin/notifyByEmail.php';
        }
        return require VIEWS . 'error/401.php';
      }


      public function addAction()
      {

      }

      public function updateAction()
      {
          //update a todo item
      }

      public function deleteAction()
      {
          //delete a todo item
      }
  }

 ?>
