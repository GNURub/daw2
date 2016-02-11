<?php
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60)));
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('PUBLICO', ROOT.'public'. DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('IMGS', ROOT . 'public/images' . DIRECTORY_SEPARATOR);
define('VIEWS', APP . 'views' . DIRECTORY_SEPARATOR);

if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}

// SMTP CONFIGG
$string = file_get_contents(ROOT . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'credentials.json');
$credentials = json_decode($string, true);
define('EMAIL', $credentials['smtp']['email']);
define('PASSWORD', $credentials['smtp']['password']);
define('SMTP_HOST', $credentials['smtp']['host']);
define('SMTP_PORT', $credentials['smtp']['port']);
define('SMTP_SECURE', $credentials['smtp']['secure']);

// Facebook Login
define('FACEBOOK_ID', $credentials['facebook']['appId']);
define('FACEBOOK_SECRET', $credentials['facebook']['appSecret']);

define('GOOGLE_ID', $credentials['google']['appId']);
define('GOOGLE_SECRET', $credentials['google']['appSecret']);



// core
require_once APP.'core/model.php';
require_once APP.'core/controller.php';
require_once APP.'core/application.php';
require_once APP.'core/log.php';

// cargamos los modelos
require_once APP.'models/Category.model.php';
require_once APP.'models/Product.model.php';
require_once APP.'models/Client.model.php';
require_once APP.'models/Color.model.php';
require_once APP.'models/Size.model.php';
require_once APP.'models/Discount.model.php';
require_once APP.'models/Subcategory.model.php';

// config
require_once APP.'config/config.php';

// services
require_once APP.'helpers/response.php';
require_once APP.'helpers/pdf.php';
require_once APP.'helpers/fb.php';
require_once APP.'helpers/go.php';
require_once APP.'helpers/utils.php';
require_once APP.'helpers/apiRedsys.php';


Log::write("Atendiendo peticion.");
$app = new Application();
exit();
