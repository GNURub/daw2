<?php

class Home
{

    public function index()
    {
        // load views
        require APP . 'views/_layout/header.php';
        require APP . 'views/home/index.php';
        require APP . 'views/_layout/footer.php';
    }

    public function signinAction()
    {
        // load views
        require APP . 'views/_layout/header.php';
        require APP . 'views/home/signin.php';
        require APP . 'views/_layout/footer.php';
    }

    public function signupAction()
    {
        // load views
        require APP . 'views/_layout/header.php';
        require APP . 'views/home/signup.php';
        require APP . 'views/_layout/footer.php';
    }
}
?>
