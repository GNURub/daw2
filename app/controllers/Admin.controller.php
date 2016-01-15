<?php


  class Admin extends Controller {
      private $_params;
      private $product;
      private $category;
      private $clients;
      static $products;
      private $isAdmin;
      static $lastItem;

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
            if(empty($itemid) || empty($this->product->toArray($itemid))){
              return header('location: /');
            }
            $clientes = $this->clients->toArray();
            $item = $this->product->toArray($itemid);


            $mail = new PHPMailer;
            // $mail->SMTPDebug = 3;

            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL;
            $mail->Password   = PASSWORD;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port       = SMTP_PORT;
            $mail->setFrom(EMAIL, 'The cat long');
            $mail->isHTML(true);
            $mail->Subject = $title;

            foreach ($clientes as $value) {
              if(EMAIL != $value['email']){
                $mail->addAddress($value['email']);
              }
              $mail->Body    = "<html>
                                  <head>
                                    <title>$title</title>
                                  </head>
                                  <body>
                                    <h2>$title</h2>
                                    <p>
                                      $detalles
                                    </p>
                                  </body>
                                </html>";
            }
            foreach ($item as $i) {
              $mail->addAttachment(IMGS. $i['path']);
            }
            $mail->AltBody = $detalles;

            if($mail->send()) {
                header('location: /');
                return;
            }



          }
          if(empty($this->_params[0]) || empty($this->product->toArray($this->_params[0]))){
            header('location: /');
            return;
          }
          $itemId = $this->_params[0];
          self::$lastItem = $itemId;

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
