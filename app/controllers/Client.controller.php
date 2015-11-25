<?php
  require APP.'model/Client.model.php';
  class Client {
      private $_params;

      public function __construct($params)
      {
          $this->_params = $params;
      }

      public function createAction()
      {
        // Creamos un nuevo cliente
        $client = new ClientsModel();
        $isValidUser = (isset($this->_params['username']) &&
                        isset($this->_params['password']) &&
                        isset($this->_params['email']) &&
                        !empty($this->_params['username']) &&
                        !empty($this->_params['password']) &&
                        !empty($this->_params['email'])
        );
        try {
          if($isValidUser){

            $hash = crypt($this->_params['password'], uniqid());
            $client->save(array(
                "username" => $this->_params['username'],
                "password" => $hash,
                "email"    => $this->_params['email']
              )
            );
            return $client->toArray();
          }
          throw new Exception("Los parametros no son correctos para ". get_class($this), 1);

        } catch (Exception $e) {
          throw new Exception($e->getMessage(), 1);
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

      public function deleteAction()
      {
          //delete a todo item
      }
  }

 ?>
