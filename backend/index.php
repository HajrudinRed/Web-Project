<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'rest/routes/UserRoutes.php';
require 'rest/routes/CategoriesRoutes.php';
require 'rest/routes/CoursesRoutes.php';
require 'rest/routes/InstructorsRoutes.php';
require 'rest/routes/ReviewsRoutes.php';
require 'rest/routes/AuthRoutes.php';
require "middleware/AuthMiddleware.php";

Flight::register('auth_service', "AuthService");
Flight::register('auth_middleware', "AuthMiddleware");
Flight::register('user_service', "UserService");
Flight::register('categories_service', "CategoriesService");
Flight::register('courses_service', "CoursesService");
Flight::register('instructors_service', "InstructorsService");
Flight::register('reviews_service', "ReviewsService");



// This wildcard route intercepts all requests and applies authentication checks before proceeding.
Flight::route('/*', function() {
   if(
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0
   ) {
       return TRUE;
   } else {
       try {
           $token = Flight::request()->getHeader("Authentication");
           if(Flight::auth_middleware()->verifyToken($token))
               return TRUE;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});

//Error Handling
Flight::map('error', function(Throwable $ex){
    $code = $ex->getCode();
    // Only use valid HTTP status codes, otherwise default to 500
    if ($code < 100 || $code > 599) {
        $code = 500;
    }
    Flight::json([
        'error' => $ex->getMessage()
    ], $code);
});
Flight::start();