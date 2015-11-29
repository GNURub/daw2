<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('VIEWS', APP . 'views' . DIRECTORY_SEPARATOR);


//core
require_once APP.'core/model.php';
require_once APP.'core/controller.php';
require_once APP.'core/application.php';
require_once APP.'core/log.php';
// cargamos los modelos
require_once APP.'models/Category.model.php';
require_once APP.'models/Product.model.php';
require_once APP.'models/Client.model.php';
require_once APP.'models/Color.model.php';
require_once APP.'models/Discount.model.php';
require_once APP.'models/Subcategory.model.php';

//config
require_once APP.'config/config.php';
require_once APP.'helpers/response.php';
require_once APP.'helpers/utils.php';
Log::write("Atendiendo peticion.");
$app = new Application();
exit();
