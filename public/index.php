<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';



$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$host = $_SERVER['HTTP_HOST']; #Get the host

$request_uri = $_SERVER['REQUEST_URI']; #Get the request URI

$full_url = $protocol . $host . $request_uri; #Get the full URL

$target_url = $protocol . $host . '/'; #Construct the target URL dynamically

// Check if the URL matches the target URL
if ($full_url === $target_url) {
    $path = app()->environmentFilePath();
    $findValue = 'CENTRAL_DOMAIN=CENTRAL_DOMAIN';
    $envData= file_get_contents($path);

    if(str_contains($envData, $findValue)) {
        $pattern = array('/CENTRAL_DOMAIN=CENTRAL_DOMAIN/i');
        $replace = array('CENTRAL_DOMAIN='.$_SERVER['HTTP_HOST']);
        file_put_contents($path, preg_replace($pattern, $replace, file_get_contents($path)));
    }
}



$kernel = $app->make(Kernel::class);
$response = $kernel->handle(
    $request = Request::capture()
)->send();
$kernel->terminate($request, $response);


