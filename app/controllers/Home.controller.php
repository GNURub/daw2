<?php
/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load views
        require APP . 'views/_layout/header.php';
        require APP . 'views/home/index.php';
        require APP . 'views/_layout/footer.php';
    }
    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function login()
    {
        // load views
        require APP . 'views/_layout/header.php';
        require APP . 'views/home/signin.php';
        require APP . 'views/_layout/footer.php';
    }
    /**
     * PAGE: exampletwo
     * This method handles what happens when you move to http://yourproject/home/exampletwo
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function register()
    {
        // load views
        require APP . 'views/_layout/header.php';
        require APP . 'views/home/signup.php';
        require APP . 'views/_layout/footer.php';
    }
}
?>
