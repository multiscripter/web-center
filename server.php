<?
define('__BACK__', dirname(__FILE__).'/back/');
define('DB_CONF', parse_ini_file(__BACK__.'conf/db.ini'));
define('LOG_CONF', __BACK__.'conf/log.ini');

require_once(__BACK__.'controllers/Controller.php');

$controller = new Controller();
$controller->handleRequiest();