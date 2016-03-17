<?php

  class Client extends Controller
  {
      private $_params;
      private $client;
      private $product;
      private $subcategory;
      protected static $fb, $go;

      public function __construct($params = array())
      {
        $this->client = new ClientModel();
        $this->product = new ProductModel();
        $this->_params = $params;
        self::$fb = new FacebookLogin();
        self::$go = new GoogleLogin();
      }

      // PERFIL USUARIO
      public function index($params = array())
      {
          if (empty($params[0])) {
            if(isset($_SESSION['username'])){

              $userData = $this->client->toArray($_SESSION['username']);
              $canAccess = (
                !empty($userData)
              );
              if ($canAccess) {
                  $orders   = $this->client->getOrders($_SESSION['username']);
                  Log::write('El usuario accede a su perfil.');
                  function detailsOrder(){
                    echo "hola";
                  }
                  return require VIEWS.'client/index.php';
              }
            }
            Log::write('El usuario no tiene acceso');
            return require VIEWS.'error/401.php';
          }
          $userData = $this->client->toArray($params[0]);
          $canAccess = (
            ($userData && !!$userData['public']) ||
            self::getSession('username') == $params[0]
          );
          if ($canAccess) {
            Log::write("El usuario accede al perfil de {$params[0]} perfil.");
            return require VIEWS.'client/index.php';
          }
          Log::write('El usuario no tiene acceso');
          return require VIEWS.'error/401.php';
      }

      // CREAR USUARIO
      public function createAction()
      {
          // Creamos un nuevo cliente
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);
            $isValidUser = (
              isset($username) &&
              isset($nombre) &&
              isset($apellidos) &&
              isset($email) &&
              isset($password) &&
              isset($con_password) &&
              isset($news) &&
              !empty($username) &&
              !empty($nombre) &&
              !empty($apellidos) &&
              !empty($email) &&
              !empty($password) &&
              !empty($con_password) &&
              $password === $con_password &&
              isValidPassword($password) &&
              isValidEmail($email)
          );

          try {
              if ($isValidUser) {
                  Log::write('Se esta intentando crear un usuario');
                  $hash = crypt($password, uniqid());
                  $this->client->save(array(
                      'username' => $username,
                      'nombre' => $nombre,
                      'apellidos' => $apellidos,
                      'email' => $email,
                      'password' => $hash,
                      'news' => $news,
                      'public' => !!$public ? 1 : 0
                    )
                  );
                  $_SESSION['username'] = $username;
                  Log::write("El usuario $username se ha creado correctamente");
                  flash('msg', 'El usuario se creó correctamente', 'Reguistro');
                  return header('Location: /client');
              }
              Log::write('Los datos pasados por POST no son correctos');
              return require VIEWS.'error/400.php';
          } catch (Exception $e) {
              $error = $e->getMessage();
              Log::write('Se ha producido una excepción al intentar crear el usuario');
              return require VIEWS.'error/500.php';
          }
        }
        return require VIEWS.'error/400.php';
      }

      // LOGIN CLIENTE
      public function signinAction()
      {
        extract($_POST);
        //read all the todo items
        $isValidUser = (
            isset($username) &&
            !empty($username) &&
            isset($password) &&
            !empty($password)
        );
        Log::write("El usuario $username se esta intentando logear");
        if ($isValidUser) {
          try {
            $userData = $this->client->toArray($username);
            if(empty($userData) || empty($userData['password'])){
              throw new Exception("No existe el usuario {$username}", 1);
            }
            if (hash_equals(
                  $userData['password'],
                  crypt($password, $userData['password'])
                 )
                ) {
                self::setSession('username', $userData['username']);
                self::setSession('admin', $userData['rol']);
                return header('location: /');
            }
            Log::write('La contraseña introducida no es correcta');
            return require VIEWS.'error/401.php';
          } catch (Exception $e) {
            $error = $e->getMessage();
            return require VIEWS.'error/500.php';
          }
        }
        $error = 'Los datos no son correctos.';
        return require VIEWS.'error/400.php';
      }


      // public function adminAction()
      // {
      //     if (!!self::getSession('username') && self::getSession('admin') == 'administrador') {
      //         return require VIEWS.'client/admin.php';
      //     }
      //     require VIEWS.'error/401.php';
      // }

      public function updateAction()
      {
          //update a todo item
      }

      // RECUPERACION CONTRASEÑA
      public function restoreAction()
      {
          extract($_POST);
          if (isset($email) && isValidEmail($email)) {
              try {
                  $client = $this->client->toArray($email);
                  if($client){
                    $body = "<html>
                    <head>
                    <title>Recuperacion</title>
                    </head>
                    <body>
                    <h2>Recuperacion password</h2>
                    <p>
                    El sistema de restauración esta en construccion
                    </p>
                    </body>
                    </html>";
                    return sendEmail(true, array($client), "Recuperacion contraseña", $body);

                  }
                  throw new Exception("No existe el cliente", 1);

              } catch (Exception $e) {
                  $error = $e->getMessage();
                  return require VIEWS.'error/500.php';
              }
          } else {
              require VIEWS.'error/400.php';
          }
      }

      public function ticketAction()
      {
          // Ajax ticket
          header('Access-Control-Allow-Origin: *');
          if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productos']) && !empty($_POST['productos'])){
            foreach ($_POST['productos'] as $pro) {
              $_SESSION['productos'][$pro['idproducto']] = array($pro['q'], $pro['size'], $pro['color']);
            }
            echo "OK";
            return;
          }
          if (!self::getSession('username')) {
            flash('msg', 'Debe loguearse para acceder.', 'Warning!', 'warning');
            return header('location: /');
          }

          if(isset($_SESSION['productos']) && !empty($_SESSION['productos'])){
            $productos = $this->_generate_products();
            return generate_ticket($productos);
          }
          flash('msg', 'No hay productos en la cesta', 'Warning!', 'warning');
          return header('location: /');
      }

      public function deleteAction()
      {
          if (!self::getSession('username')) {
              flash('msg', 'Debe loguearse para acceder.', 'Warning!', 'warning');
              return header('location: /');
          }
          try {
              if ($this->client->delete(self::getSession('username'))) {
                  self::destroySession('username');
                  self::destroySession('admin');
                  self::destroySession('productos');
                  flash('msg', 'Se ha eliminado su cuenta satisfactoriamente', 'Administración');
                  return header('location: /');
              }
          } catch (Exception $e) {
              $error = $e->getMessage();
              return require VIEWS.'error/500.php';
          }
      }
      public function goAction($a){
        $res = self::$go->getToken();
        if (!empty($res['user'])) {
          $email = filter_var($res['user']['email'], FILTER_SANITIZE_EMAIL);
          $userDB = $this->client->toArray($email);
          if (empty($userDB)) {
            $na = explode(' ', utf8_decode($res['user']['name']));
            $name = $na[0];
            array_shift($na);
            try {
              $this->client->save(array(
                'email' => $email,
                'username' => $res['user']['id'],
                'nombre' => $name,
                'apellidos' => implode(" ", $na),
                'provider'  => 'google'
              ));
              self::setSession('username', $res['user']['id']);
            } catch (Exception $e) {
                exit($e);
            }

          }else {
              // Ya lo teniamos
              self::setSession('username', $userDB['username']);
              self::setSession('admin',    $userDB['rol']);
          }
          return header('location: /');
        }elseif ($res['error']) {
            switch ($res['error']) {
              case 400:
                return require VIEWS.'error/400.php';
                break;
              case 401:
                return require VIEWS.'error/401.php';
                break;
              default:
                return require VIEWS.'error/404.php';
                break;
            }
        }
      }
      public function fbAction($a)
      {
          $res = self::$fb->getToken();
          if (!empty($res['user'])) {
              $email = filter_var($res['user']->getField('email'), FILTER_SANITIZE_EMAIL);
              $userDB = $this->client->toArray($email);
              if (empty($userDB)) {
                  // el usuario de fb se debe registrar
                  $na = explode(' ', utf8_decode($res['user']->getField('name')));
                  $name = $na[0];
                  array_shift($na);
                  try {
                      $this->client->save(array(
                        'email' => $email,
                        'username' => $res['user']->getField('id'),
                        'nombre' => $name,
                        'apellidos' => implode(" ", $na),
                        'provider' => 'facebook'
                      ));
                      self::setSession('username', $res['user']->getField('id'));
                  } catch (Exception $e) {
                      exit($e);
                  }
              } else {
                  // Ya lo teniamos
                  self::setSession('username', $userDB['username']);
                  self::setSession('admin',    $userDB['rol']);
              }

              return header('location: /');
          } elseif ($res['error']) {
              switch ($res['error']) {
                case 400:
                  return require VIEWS.'error/400.php';
                  break;
                case 401:
                  return require VIEWS.'error/401.php';
                  break;
                default:
                  return require VIEWS.'error/404.php';
                  break;
              }
          }
      }


      public function checkoutAction()
      {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productos']) && !empty($_POST['productos'])) {

          $hash_compra = md5(uniqid(time()));
          foreach ($_POST['productos'] as $pro) {
            $_SESSION['productos'][$pro['idproducto']] = array($pro['q'], $pro['size'], $pro['color']);
          }

          $miObj = new RedsysAPI;

        	// Valores de entrada
        	$fuc="999008881";
        	$terminal="871";
        	$moneda="978";
        	$trans="0";
        	$url= URL;
          $urlKO= URL . "client/ko";
          $urlOK= URL . "client/ok";
        	$id = $hash_compra;
        	$amount = number_format($_POST['amount'], 2, '', '');

        	// Se Rellenan los campos
        	$miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
        	$miObj->setParameter("DS_MERCHANT_ORDER",strval($id));
        	$miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
        	$miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda);
        	$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
        	$miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
        	$miObj->setParameter("DS_MERCHANT_MERCHANTURL",$url);
        	$miObj->setParameter("DS_MERCHANT_URLOK",$urlOK);
        	$miObj->setParameter("DS_MERCHANT_URLKO",$urlKO);

        	//Datos de configuración
        	$version="HMAC_SHA256_V1";
        	$kc = 'Mk9m98IfEblmPfrpsawt7BmxObt98Jev';//Clave recuperada de CANALES
        	// Se generan los parámetros de la petición
        	$request = "";
        	$params = $miObj->createMerchantParameters();
        	$signature = $miObj->createMerchantSignature($kc);
          return require VIEWS.'client/confirmpay.php';
        }
        if (self::getSession('username')) {
          $productos = $this->_generate_products();
          return require VIEWS.'client/checkout.php';
        }

        return header('location: /');
      }

      private function _generate_products(){
        $productos = array();
        if(self::getSession('productos')){
          $a = self::getSession('productos');
        }else{
          $a = array();
        }
        foreach ($a as $id => $q) {
          $pro = $this->product->toArray($id);
          $pro['q'] = $q[0];
          if(isset($q[1])){
            $pro['size'] = $q[1];
          }
          if(isset($q[2])){
            $pro['color'] = $q[2];
          }

          array_push($productos, $pro);
        }
        return $productos;
      }

      public function okAction(){
        // PRODUCTION
        // print_r($_POST);
        // exit;
        if(isset($_SERVER['HTTP_REFERER']) &&
        $_SERVER['HTTP_REFERER'] == "http://jguasch.esy.es/redsys/lacaixaOK.php"){
          if (!empty( $_POST ) ) {//URL DE RESP. ONLINE
                  $miObj = new RedsysAPI;
                  $version = $_POST["Ds_SignatureVersion"];
                  $datos = $_POST["Ds_MerchantParameters"];
                  $signatureRecibida = $_POST["Ds_Signature"];
                  
        
                  $decodec = $miObj->decodeMerchantParameters($datos);	
                  $kc = 'Mk9m98IfEblmPfrpsawt7BmxObt98Jev'; //Clave recuperada de CANALES
                  $firma = $miObj->createMerchantSignatureNotif($kc,$datos);	
        
                  if ($firma != $signatureRecibida){
                    flash('msg', 'El servidor no responde correctamente', 'Error', 'error');
                    header('location: /');
                    return;
                  }
          }
          try {
            $hash_compra = md5(uniqid(time()));
            $id_compra = $this->client->save(array(
              "hash_compra" => $hash_compra,
              "estado"      => "pagado",
              "username"    => self::getSession("username")
            ), "compras");

            $productos = $this->_generate_products();
            // Guardar compras por productos
            foreach ($productos as $id => $pro) {
              $this->client->save(array(
                "idcompra"   => $id_compra,
                "idproducto" => $pro['idproducto'],
                "cantidad"   => $pro['q'],
                "idtalla"    => $pro['size'],
                "idcolor"    => $pro['color'],
                "username"   => self::getSession("username")
              ), "compras_productos_tallas_colores");
            }


            $client = $this->client->toArray(self::getSession('username'));
            if(!empty($productos) && !empty($client)){
              generate_facture($productos , $client);
            }
            return header('location: /');
          } catch (Exception $e) {
            $error = $e->getMessage();
            echo $error;
            exit;
            // return require VIEWS. 'error/500.php';
          }
          return;
        }
        $error = "El host de peticion debe ser -> http://jguasch.esy.es/redsys/lacaixaOK.php";
        require VIEWS.'error/401.php';
        return;
      }

      public function koAction(){
        return require VIEWS.'error/400.php';
      }

  }
