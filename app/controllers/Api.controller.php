<?php
// /product/[{id}]/
// /category/{cat}
// /subcategory/{sub}
class Api extends Controller {
    private $_params;
    private $product;
    private $category;
    private $subcategory;
    private $clients;
    static $products;
    private $isAdmin;
    static $lastItem;

    public function __construct($params = array())
    {
      $this->product    = new ProductModel();
      $this->clients    = new ClientModel();
      $this->category   = new CategoryModel();
      $this->subcategory= new SubcategoryModel();
      $this->_params    = $params;
      self::$products   = $this->product->toArray();
      $this->isAdmin    = (self::getSession('admin') == "admin" ||
                          self::getSession('admin') == "administrador");
    }

    public function index($params = array()){
      $this->productAction();
    }

    public function productAction()
    {
        try {
          $id = !empty($this->_params[0]) ? $this->_params[0] : false;
          $proucts = $this->product->toArray($id);
          echo json_encode($proucts);
        } catch (Exception $e) {
          $error = array(
            'error' => 200,
            'errorMsg' => $e->getMessage(),
          );
          echo json_encode($error);
        }
        return;
    }

    public function categoryAction()
    {

      $idcat = !empty($this->_params[0]) ? $this->_params[0] : false;
      if(!$idcat){
        $error = array(
          'error' => 400,
          'errorMsg' => "Debe de indicar una categoría correcta",
        );
        echo json_encode($error);
        return;
      }
      try {
        $products = $this->product->selecWithCategorySubcatAndProduct($idcat);
        if (empty($products)) {
          $products = array(
            'error' => 400,
            'errorMsg' => 'No hay productos',
          );
        }
        echo json_encode($products);
      } catch (Exception $e) {
        $error = array(
          'error' => 200,
          'errorMsg' => $e->getMessage(),
        );
        echo json_encode($error);
      }
      return;
    }

    function ordersAction(){
      try {
        $user = !empty($this->_params[0]) ? $this->_params[0] : false;
        $id = !empty($this->_params[1]) ? $this->_params[1] : false;
        $pedidos = $this->clients->getOrders($user, $id);
        echo json_encode($pedidos);
      } catch (Exception $e) {
        $error = array(
          'error' => 200,
          'errorMsg' => $e->getMessage(),
        );
        echo json_encode($error);
      }
      return;
    }

}

?>
