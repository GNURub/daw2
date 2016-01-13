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
            // function send_email($user){
            //   mail($user['email'], $title, $etalles);
            //   sleep(2);
            // }
            // foreach ($clientes as $value) {
            //   if(EMAIL != $value['email']){
            //     send_email($value);
            //   }
            // }


            $mail = new PHPMailer;
            $mail->SMTPDebug = 3;

            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL;
            $mail->Password   = PASSWORD;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port       = SMTP_PORT;           

            $mail->setFrom(EMAIL, 'Mailer');
            foreach ($clientes as $value) {
              if(EMAIL != $value['email']){
                $mail->addAddress($value['email']);
              }
            }

            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML
            //
            $mail->Subject = $title;
            $mail->Body    = $detalles;
            $mail->AltBody = $detalles;

            if($mail->send()) {
                header('location: /');
                return;
            }



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
