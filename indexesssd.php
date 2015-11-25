<?php
  define('VIEWS', dirname(__FILE__).'/views');
  include_once 'helpers/response.php';
  // include_once 'helpers/router.php';

  //Modelos
  include_once 'models/Category.model.php';
  include_once 'models/Client.model.php';
  include_once 'models/Discount.model.php';
  // // include_once 'models/Image.model.php';
  // // include_once 'models/Order.model.php';
  // // include_once 'models/PayMethod.model.php';
  // // include_once 'models/Product.model.php';
  // // include_once 'models/Rol.model.php';
  // // include_once 'models/ShoppingCart.model.php';
  // // include_once 'models/Size.model.php';
  //
  //Capturamos cualquier excepcion
  try {
      //Obtenemos todos los parametros GET/POST
      $params = $_REQUEST;
      //Obtenemos el formato correcto del controlador

      if(isset($params['controller'])){
        $_controller = $params['controller'];
        $controller = ucfirst(strtolower($_controller));
      }else {
        $controller = "";
      }

      //Accion que realiza el usuario sobre el modelo
      $_action = '';
      if(isset($params['action']) && !empty($params['action'])){
        $_action     = $params['action'];
        $action = strtolower($_action).'Action';
      }else {
        switch ($_SERVER['REQUEST_METHOD']) {
          case 'POST':
            # code...
            $action = "createAction";
            break;
          case 'PUT':
            $action = "createAction";
            break;

          case 'UPDATE':
            $action = "createAction";
            break;
          case 'GET':
            $action = "createAction";
            break;
        }
      }

      // Comprobamos si existe el controlador
      if( file_exists("controllers/{$controller}.controller.php") ) {
          include_once "controllers/{$controller}.controller.php";
      } else {
          echo $controller;
          Router::renderView('error/400', array(
              'error' => 'El controlador no es válido'
            )
          );
      }

      // Creamos una nueva instancia del controlador
      // y le pasamos los parametros desde el request
      $controller = new $controller($params);

      // Comprobamos que exista el controlador sino lanzamos una excepcion
      if( @method_exists($controller, $action) === false ) {
        Router::renderView('error/400', array(
            'error' => 'La accion no es correcta'
          )
        );
      }

      try {
        Router::renderView(strtolower($_controller).'/'.strtolower($_action), $controller->$action());
      } catch (Exception $e) {
        Router::renderView('error/400', array(
            'error' => $e->getMessage()
          )
        );
      }

  } catch( Exception $e ) {
      Router::setView('error/500', $e->getMessage());
  }
  exit();
?>
