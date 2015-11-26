<?php
  require APP.'models/Product.model.php';

  class Product extends Controller {
      private $_params;
      private $product;


      public function __construct($params = array())
      {
          $this->product = new ProductModel();
          $this->_params = $params;
      }

      public function index($params = array()){

      }

      public function createAction()
      {
          extract($_POST);



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
