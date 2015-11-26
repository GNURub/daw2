<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('VIEWS', APP . 'views' . DIRECTORY_SEPARATOR);
if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}
require APP . 'config/config.php';
require APP . 'helpers/response.php';
require APP . 'helpers/utils.php';
require APP . 'core/application.php';
require APP . 'core/controller.php';
require APP . 'core/model.php';
$app = new Application();
exit();
