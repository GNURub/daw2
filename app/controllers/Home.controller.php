<?php

class Home extends Controller
{

    public function index()
    {
        // load VIEWSs
        require VIEWS . '_layout/header.php';
        require VIEWS . 'home/index.php';
        require VIEWS . '_layout/footer.php';
    }

    public function signinAction()
    {
        // load VIEWSs
        require VIEWS . '_layout/header.php';
        require VIEWS . 'home/signin.php';
        require VIEWS . '_layout/footer.php';
    }

    public function signupAction()
    {
        // load VIEWSs
        require VIEWS . '_layout/header.php';
        require VIEWS . 'home/signup.php';
        require VIEWS . '_layout/footer.php';
    }

    public function lostAction()
    {
        // load VIEWSs
        require VIEWS . '_layout/header.php';
        require VIEWS . 'home/lost.php';
        require VIEWS . '_layout/footer.php';
    }


}
?>
