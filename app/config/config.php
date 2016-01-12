<?php
/**
 * Configuration
 *
 */
/**
 * Configuration for: Error reporting
 */
define('ENVIRONMENT', 'producction');
if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    /**
     * Configuration for: Database
     */
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'thecatlong');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');
    define('DB_CHARSET', 'utf8');
}else{
  define('DB_HOST', getenv("OPENSHIFT_MYSQL_DB_HOST"));
  define('DB_NAME', 'thecatlong');
  define('DB_USER', 'admin5AjSk6P');
  define('DB_PASS', 'CpCQV1xlJcRt');
  define('DB_CHARSET', 'utf8');
}
/**
 * Configuration for: URL

 * URL_PROTOCOL:
 * The protocol. Don't change unless you know exactly what you do.
 *
 * URL_DOMAIN:
 * The domain. Don't change unless you know exactly what you do.
 *
 * URL_SUB_FOLDER:
 * The sub-folder. Leave it like it is, even if you don't use a sub-folder (then this will be just "/").
 *
 * URL:
 * The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
 * then replace this line with full URL (and sub-folder) and a trailing slash.
 */
define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', 'http://');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

?>
