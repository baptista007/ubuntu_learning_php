<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$eng = parse_ini_file("languages/english.ini");
//$port = parse_ini_file("languages/portuguese.ini");
//$index = 0;
//$port_array = array();
//
//foreach ($port as $key => $value) {
////    $port_array[] = ucfirst($value);
//    $port_array[] = $key;
//}
//foreach ($eng as $key => $value) {
//    if (!in_array($key, $port_array)) {
//        echo $key . ' = "' . $value . '" <br />';
//    }
//    $index++;
//echo $value, '<br />';
//}
//return;

session_start(); // Start or Resume Session
require('config.php');

#Erro Reporting For debugging during development
if (DEVELOPMENT_MODE == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(E_ALL);
    ini_set('log_errors', 'On');
    ini_set('error_log', 'error.log');
    ini_set('display_errors', 'Off');
}

// Application configurations Settings

/**
 * Initialize The Model Class From Model Dir
 * @return null
 */
function autoloadModel($className) {
    $filename = MODELS_DIR . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}

/**
 * Initialize The Controller Class From Controller Dir
 * @return null
 */
function autoloadController($className) {
    $filename = CONTROLLERS_DIR . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}

/**
 * Initialize The Library File From Libs Dir
 * @return boolean
 */
function autoloadLibrary($className) {
    $filename = LIBS_DIR . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}

/**
 * Initialize The Helper Class From helper Dir
 * @return null
 */
function autoloadHelper($className) {
    $filename = HELPERS_DIR . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}

// Register Autoloaders
spl_autoload_register("autoloadModel");
spl_autoload_register("autoloadController");
spl_autoload_register("autoloadLibrary");
spl_autoload_register("autoloadHelper");

//Initialize Global Functions Helpers
require(HELPERS_DIR . 'Functions.php');
require(HELPERS_DIR . 'Constants.php');

$lang = new Lang; // Initialize language class and load language phrases
$csrf = new Csrf; // Initialize Csrf class and generate new application token
$csrf_token = $csrf::$token;

// Application Core Files
require(SYSTEM_DIR . 'BaseController.php');
require(SYSTEM_DIR . 'SecureController.php');
require(SYSTEM_DIR . 'BaseView.php');
require(SYSTEM_DIR . 'Router.php');

//Initialize global settings
$base = new BaseController;
$db = $base->GetModel();
$core_settings = $db->rawQueryOne("select * from core");

$page = new Router;

$page->init(); // Bootstrap Page From the Current URL