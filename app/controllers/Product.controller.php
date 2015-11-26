<?php
  require APP.'models/Product.model.php';
  require_once APP.'models/Client.model.php';

  class Product extends Controller {
      private $_params;
      private $product;


      public function __construct($params = array())
      {
          $this->product = new ProductModel();
          $this->admin   = new ClientsModel();
          $this->_params = $params;
      }

      public function index($params = array()){

      }

      public function jsonAction(){
        try {
          $proucts = $this->product->toArray();
          echo json_encode($proucts);
        } catch (Exception $e) {
          $error = array(
            'error' => 200,
            'errorMsg' => $e->getMessage()
          );
          echo json_encode($error);
        }

      }

      public function createAction()
      {
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            extract($_POST);
          }else{
            
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
