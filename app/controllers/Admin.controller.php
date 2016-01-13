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


            $mail->SMTPDebug = 3;                                 // Enable verbose debug output
            $mail = new PHPMailer;

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host       = SMTP_HOST;                       // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                               // Enable SMTP authentication
            $mail->Username   = EMAIL;                              // SMTP username
            $mail->Password   = PASSWORD;                           // SMTP password
            $mail->SMTPSecure = SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = SMTP_PORT;                                    // TCP port to connect to

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

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                return header('location: /');
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
