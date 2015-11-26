<?php
  require APP.'model/Category.model.php';
  class Category extends Controller {
      private $_params;

      public function __construct($params = array())
      {
          $this->_params = $params;
      }

      public function createAction()
      {
        // Creamos una nueva categoria
        $category = new CategoryModel();
        $isValidCategory = (isset($this->_params['title']) &&
                        !empty($this->_params['title'])
        );
        try {
          if($isValidCategory){
            $category->save(array(
                "title" => $this->_params['title']
              )
            );
            return $category->toArray();
          }
          throw new Exception("Los parametros no son correctos", 1);

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
