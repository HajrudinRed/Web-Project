<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../../vendor/autoload.php';

// Dynamic server configuration based on request
$port = $_SERVER['SERVER_PORT'] ?? '80';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['SERVER_NAME'] ?? 'localhost';

if($port === '8000') {
    define('BASE_URL', $protocol . '://' . $host . ':' . $port);
} else if($host == 'localhost' || $host == '127.0.0.1'){
   define('BASE_URL', 'http://localhost/web-project/backend');
} else {
   define('BASE_URL', 'https://localhost/web-project/backend');
}
$openapi = \OpenApi\Generator::scan([
   __DIR__ . '/doc_setup.php',
   __DIR__ . '/../../../rest/routes'
]);
header('Content-Type: application/json');
echo $openapi->toJson();
?>
