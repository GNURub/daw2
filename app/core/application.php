<?php
class Application
{
    /** @var null The controller */
    private $url_controller = null;
    /** @var null The method (of the above controller), often also named "action" */
    private $url_action = null;
    /** @var array URL parameters */
    private $url_params = array();
    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct()
    {
        // create array with URL parts in $url
        $this->splitUrl();
        // check for controller: no controller given ? then load start-page
        if ($this->url_controller) {
          $controller = ucfirst(strtolower($this->url_controller));
          $pathController = APP . "controllers/{$controller}.controller.php";
          if( file_exists($pathController) ) {
            // llamamos al archivo controlador
            require $pathController;
            $action = strtolower($this->url_action).'Action';
            $this->url_controller = new $controller();
            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $action)) {
                if (!empty($this->url_params)) {
                    // Call the method and pass arguments to it
                    call_user_func_array(array($this->url_controller, $action), $this->url_params);
                } else {
                    // If no parameters are given, just call the method without parameters, like $this->home->method();
                    $this->url_controller->{$action}();
                }
            } else {
                if (strlen($this->url_action) == 0) {
                    // no action defined: call the default index() method of a selected controller
                    $this->url_controller->index();
                }
                else {
                    header('location: ' . URL . 'error');
                }
            }
          }
        } elseif (!$this->url_controller) {
            require APP . 'controllers/Home.controller.php';
            $page = new Home();
            $page->index();

        } else {
            header('location: ' . URL . 'error');
        }
    }
    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if (isset($_GET['url'])) {
            // split URL
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = isset($url[1]) ? $url[1] : null;
            
            unset($url[0], $url[1]);

            $this->url_params = array_values($url);
   
//             echo 'Controller: ' . $this->url_controller . '<br>';
//             echo 'Action: ' . $this->url_action . '<br>';
//             echo 'Parameters: ' . print_r($this->url_params, true) . '<br>';
        }
    }
}
?>
