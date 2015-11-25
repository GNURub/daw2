<?php
  require APP.'model/Discount.model.php';
  class Discount {
      private $_params;

      public function __construct($params)
      {
          $this->_params = $params;
      }

      public function createAction()
      {
        // Creamos una nueva categoria
        $discount = new DiscountModel();
        $isValidDiscount = (isset($this->_params['fechainicio']) &&
                        !empty($this->_params['fechainicio']) &&
                        isset($this->_params['fechafin']) &&
                        !empty($this->_params['fechafin']) &&
                        isset($this->_params['porcentaje']) &&
                        !empty($this->_params['porcentaje'])
        );
        try {
          if($isValidDiscount){
            $discount->save(array(
              "fechainicio" => $this->_params['fechainicio'],
              "fechafin"    => $this->_params['fechafin'],
              "porcentaje"  => $this->_params['porcentaje']
              )
            );
            return $discount->toArray();
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
