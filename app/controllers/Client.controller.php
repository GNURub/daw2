<?php

  class Client extends Controller
  {
      private $_params;
      private $client;
      private $product;
      protected static $fb, $go;

      public function __construct($params = array())
      {
        $this->client = new ClientModel();
        $this->product = new ProductModel();
        $this->_params = $params;
        self::$fb = new FacebookLogin();
        self::$go = new GoogleLogin();
      }

      public function index($params = array())
      {
          if (!self::getSession('username')) {
              Log::write('Se ha intentado a acceder a la zona de usuarios registrados /client');
              return header('location: /');
          }
          if (empty($params[0])) {
            $userData = $this->client->toArray($_SESSION['username']);
            $canAccess = (
              !empty($userData)
            );
            if ($canAccess) {
                Log::write('El usuario accede a su perfil.');
                return require VIEWS.'client/index.php';
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
                    )
                  );
                  $_SESSION['username'] = $username;
                  Log::write("El usuario $username se ha creado correctamente");
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
            if (hash_equals($userData['password'], crypt($password, $userData['password']))) {
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

      public function adminAction()
      {
          if (!!self::getSession('username') && self::getSession('admin') == 'administrador') {
              return require VIEWS.'client/admin.php';
          }
          require VIEWS.'error/401.php';
      }

      public function updateAction()
      {
          //update a todo item
      }

      public function restoreAction()
      {
          extract($_POST);
          if (isset($email)) {
              try {
                  $this->client->toArray($email);
              } catch (Exception $e) {
                  $error = $e->getMessage();
                  return require VIEWS.'error/500.php';
              }
          } else {
              require VIEWS.'error/400.php';
          }
      }

      public function factureAction()
      {
          if (!self::getSession('username')) {
              return header('location: /');
          }

          $productos = array();
          foreach (self::getSession('productos') as $id => $q) {
              $pro = $this->product->toArray($id);
              $pro['q'] = $q;
              array_push($productos, $pro);
          }

          return generate_facture($productos);
      }

      public function deleteAction()
      {
          if (!self::getSession('username')) {
              return header('location: /');
          }
          try {
              if ($this->client->delete(self::getSession('username'))) {
                  self::destroySession('username');
                  self::destroySession('admin');
                  self::destroySession('productos');
                  return header('location: /');
              }
          } catch (Exception $e) {
              $error = $e->getMessage();
              return require VIEWS.'error/500.php';
          }
      }

      public function fbAction($a)
      {
          $res = self::$fb->getToken();
          if (!empty($res['user'])) {
              $userDB = $this->client->toArray($res['user']->getField('email'));
              if (empty($userDB)) {
                  // el usuario de fb se debe registrar
                  $na = explode(' ', $res['user']->getField('name'));
                  array_shift($na);
                  try {
                      $this->client->save(array(
                        'email' => $res['user']->getField('email'),
                        'username' => $res['user']->getField('id'),
                        'nombre' => $na[0],
                        'apellidos' => implode($na),
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

          if (self::getSession('username')) {
            $productos = array();
            if(self::getSession('productos')){
              $a = self::getSession('productos');
            }else{
              $a = array();
            }
            foreach ($a as $id => $q) {
              $pro = $this->product->toArray($id);
              $pro['q'] = $q;
              array_push($productos, $pro);
            }

            return require VIEWS.'client/checkout.php';
          }
          return header('location: /');
      }
  }
