<?php
  require APP.'models/Client.model.php';

  class Client extends Controller {
      private $_params;
      private $client;


      public function __construct($params = array())
      {
          $this->client = new ClientsModel();
          $this->_params = $params;
      }

      public function index($params = array()){
        if(!self::getSession('username')){
          header('location: /');
        }else{
          if($params[0] == $_SESSION['username'] || empty($params[0])){
            $userData = $this->client->toArray($_SESSION['username']);
            require VIEWS . '_layout/header.php';
            require VIEWS . 'client/index.php';
            require VIEWS . '_layout/footer.php';
          }else{
            require VIEWS . 'error/401.php';
          }
        }
      }

      public function createAction()
      {
          // Creamos un nuevo cliente
          // $client = new ClientsModel();
          // list($username, $name, $apellidos, $email, $pass, $cpass) = $this->_params;
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
              header('Location: /client');
              // require VIEWS . '_layout/header.php';
              // require VIEWS . 'home/index.php';
              // require VIEWS . '_layout/footer.php';
            }else{
              require VIEWS . 'error/400.php';
            }

          } catch (Exception $e) {
            $error = $e->getMessage();
            require VIEWS . 'error/500.php';
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
        if($isValidUser){
          try {
            $userData = $this->client->toArray($username);
            if(hash_equals($userData['password'], crypt($password, $userData['password']))){
              self::setSession('username', $userData['username']);
              header('location: /client');
            }else{
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


      public function readAction()
      {
          //read all the todo items
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
