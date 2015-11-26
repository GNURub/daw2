<?php
  require APP.'models/Client.model.php';
  class Client {
      private $_params;

      public function __construct($params = array())
      {
          $this->_params = $params;
      }

      public function index($params = array()){
        require VIEWS . '_layout/header.php';
        require VIEWS . 'client/index.php';
        require VIEWS . '_layout/footer.php';
      }

      public function createAction()
      {
          // Creamos un nuevo cliente
          $client = new ClientsModel();
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
              $client->save(array(
                  "username"  => $username,
                  "nombre"    => $nombre,
                  "apellidos" => $apellidos,
                  "email"     => $email,
                  "password"  => $hash
                )
              );
              $_SESSION['username'] = $username;
              require VIEWS . '_layout/header.php';
              require VIEWS . 'home/index.php';
              require VIEWS . '_layout/footer.php';
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
      }


      public function readAction()
      {
          //read all the todo items
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
