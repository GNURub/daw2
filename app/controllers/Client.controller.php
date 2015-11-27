<?php

  class Client extends Controller {
      private $_params;
      private $client;


      public function __construct($params = array())
      {
          $this->client = new ClientModel();
          $this->_params = $params;
      }

      public function index($params = array()){
        if(!self::getSession('username')){
          Log::write("Se ha intentado a acceder a la zona de usuarios registrados /client");
          header('location: /');
        }else{
          if(empty($params[0])){
            $userData = $this->client->toArray($_SESSION['username']);
            $canAccess = (
              !empty($userData)
            );
            if($canAccess){
              Log::write("El usuario accede a su perfil.");
              require VIEWS . 'client/index.php';
              return;
            }
            Log::write("El usuario no tiene acceso");
            require VIEWS . 'error/401.php';
            return;
          }else{
            $userData = $this->client->toArray($params[0]);
            $canAccess = (
              ($userData && !!$userData['public']) ||
              self::getSession('username') == $params[0]
            );
            if($canAccess){
              Log::write("El usuario accede al perfil de {$params[0]} perfil.");
              require VIEWS . 'client/index.php';
              return;
            }
            Log::write("El usuario no tiene acceso");
            require VIEWS . 'error/401.php';
            return;
          }
        }
      }

      public function createAction()
      {
          // Creamos un nuevo cliente
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
            if($isValidUser){
              Log::write("Se esta intentando crear un usuario");
              $hash = crypt($password, uniqid());
              $this->client->save(array(
                  "username"  => $username,
                  "nombre"    => $nombre,
                  "apellidos" => $apellidos,
                  "email"     => $email,
                  "password"  => $hash
                )
              );
              $_SESSION['username'] = $username;
              Log::write("El usuario $username se ha creado correctamente");
              header('Location: /client');
              // require VIEWS . '_layout/header.php';
              // require VIEWS . 'home/index.php';
              // require VIEWS . '_layout/footer.php';
            }else{
              Log::write("Los datos pasados por POST no son correctos");
              require VIEWS . 'error/400.php';
            }

          } catch (Exception $e) {
            $error = $e->getMessage();
            Log::write("Se ha producido una excepción al intentar crear el usuario");
            require VIEWS . 'error/500.php';
          }
        }else{
          require VIEWS . 'error/400.php';
        }

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
        if($isValidUser){
          try {
            $userData = $this->client->toArray($username);

            if(hash_equals($userData['password'], crypt($password, $userData['password']))){
              self::setSession('username', $userData['username']);
              self::setSession('admin', $userData['rol']);
              header('location: /');
            }else{
              Log::write("La contraseña introducida no es correcta");
              require VIEWS . 'error/401.php';
            }
          } catch (Exception $e) {
            $error = $e->getMessage();
            require VIEWS . 'error/500.php';
          }
        }else{
          $error = "Los datos no son correctos.";
          require VIEWS . 'error/400.php';
        }
      }


      public function adminAction()
      {
          if(!!self::getSession('user') && self::getSession('admin') == 'administrador'){
            require VIEWS . 'client/admin.php';
            return;
          }
          require VIEWS . 'error/401.php';
      }

      public function updateAction()
      {
          //update a todo item
      }

      public function restoreAction()
      {
        extract($_POST);
        if(isset($email)){
          try {
            $this->client-toArray($email);
          } catch (Exception $e) {
            $error = $e->getMessage();
            require VIEWS. 'error/500.php';
          }

        }else{
          require VIEWS. 'error/400.php';
        }
      }

      public function deleteAction()
      {
        if(!self::getSession('username')){
          header('location: /');
        }else{
          try {
            if($this->client->delete(self::getSession('username'))){
              self::destroySession('username');
              self::destroySession('admin');
              header('location: /');
            }
          } catch (Exception $e) {
            $error = $e->getMessage();
            require VIEWS. 'error/500.php';
          }

        }
      }
  }

 ?>
