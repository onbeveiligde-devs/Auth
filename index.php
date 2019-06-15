<?php
declare (strict_types = 1);
header('Content-Type: application/json');
date_default_timezone_set('UTC');

// version
$v = (double) phpversion();
if (!is_double($v) || $v < 7.3) {
    http_response_code(200); // 500
    die(json_encode((object) [
        'error' => [
            'type' => 'Server Outdated',
            'message' => 'This site is not available due to an outdated server. Please, update the server.',
            'version' => phpversion()
        ],
    ]));
}

// require manually for autoload error handling
$path = getcwd() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR;
require_once $path . 'Exception.php';
require_once $path . 'ErrorHandler.php';
use app\core\{
    ErrorHandler as ErrorHandler,
    Exception as Exception
};

// automatic load classes
spl_autoload_register(function ($class) {
    // $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $class = preg_replace('/\\\/', DIRECTORY_SEPARATOR, $class);
    $file = getcwd() . DIRECTORY_SEPARATOR . $class . '.php';
    if (!file_exists($file)) {
        http_response_code(200); // 500
        die(json_encode((object) [
            'error' => [
                'type' => 'Include Error',
                'message' => 'Not Found',
                'class' => $class,
                'file' => $file,
                'path' => $path
            ],
        ]));
    } else include_once $file;
});

// handle errors
error_reporting(0);
register_shutdown_function(array('app\core\ErrorHandler', 'critical'));
set_error_handler(array('app\core\ErrorHandler', 'error'));

// start guest or user with
// HTTP GET, POST, PUT or DELETE
session_start(); 
$app = new app\endpoint\Router(
    getcwd() . DIRECTORY_SEPARATOR,
    'app' . DIRECTORY_SEPARATOR 
    . 'endpoint' . DIRECTORY_SEPARATOR 
    . (isset($_SERVER["REQUEST_METHOD"]) ? 
        strtolower($_SERVER["REQUEST_METHOD"]) 
        : 'get'
    ) . DIRECTORY_SEPARATOR
);
// parse URL and route
$url = $app->parseUrl();
$app->route($url);

// $app = new app\endpoint\Router(
//     'app\endpoint\post',
//     'Key',
//     'verify'
// );

// run if found
if ($app->find()) {
    $app->run();
} else {
    new app\core\NotFound();
}
