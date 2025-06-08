<?php
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
Flight::group('/auth', function() {
   /**
    * @OA\Post(
    *     path="/auth/register",
    *     summary="Register new user.",
    *     description="Add a new user to the database.",
    *     tags={"auth"},
    *     security={
    *         {"ApiKey": {}}
    *     },
    *     @OA\RequestBody(
    *         description="Add new user",
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 required={"password", "email", "name", "role"},
    *                 @OA\Property(
    *                     property="role", 
    *                     type="string", 
    *                     example="admin", 
    *                     description="User name"
    *                 ),
    *                 @OA\Property(
    *                     property="name", 
    *                     type="string", 
    *                     example="John Doe", 
    *                     description="User name"
    *                 ),
    *                 @OA\Property(
    *                     property="password",
    *                     type="string",
    *                     example="some_password",
    *                     description="User password"
    *                 ),
    *                 @OA\Property(
    *                     property="email",
    *                     type="string",
    *                     example="demo@gmail.com",
    *                     description="User email"
    *                 )
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="User has been added."
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal server error."
    *     )
    * )
    */
   Flight::route("POST /register", function () {
       $data = Flight::request()->data->getData();

       $response = Flight::auth_service()->register($data);
          Flight::json($response);
/*
       if ($response['success']) {
           Flight::json([
               'message' => 'User registered successfully',
               'data' => $response['data']
           ]);
       } else {
           Flight::halt(500, $response['error']);
       }
           */

   });   /**
    * @OA\Post(
    *      path="/auth/login",
    *      tags={"auth"},
    *      summary="Login to system using email and password",
    *      @OA\Response(
    *           response=200,
    *           description="User data and JWT token",
    *           @OA\JsonContent(
    *               @OA\Property(property="message", type="string", example="User logged in successfully"),
    *               @OA\Property(
    *                   property="data",
    *                   type="object",
    *                   @OA\Property(property="id", type="integer", example=65),
    *                   @OA\Property(property="name", type="string", example="John Doe"),
    *                   @OA\Property(property="email", type="string", example="demo@gmail.com"),
    *                   @OA\Property(property="role", type="string", example="admin"),
    *                   @OA\Property(property="created_at", type="string", example="2025-06-03 22:23:00"),
    *                   @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
    *               )
    *           )
    *      ),
    *      @OA\Response(
    *           response=500,
    *           description="Login failed",
    *           @OA\JsonContent(
    *               @OA\Property(property="error", type="string", example="Invalid username or password.")
    *           )
    *      ),
    *      @OA\RequestBody(
    *          description="User credentials",
    *          required=true,
    *          @OA\JsonContent(
    *              required={"email","password"},
    *              @OA\Property(property="email", type="string", example="demo@gmail.com", description="User email address"),
    *              @OA\Property(property="password", type="string", example="some_password", description="User password")
    *          )
    *      )
    * )
    */   Flight::route('POST /login', function() {
       try {
           $data = Flight::request()->data->getData();
           $response = Flight::auth_service()->login($data);
      
           if ($response['success']) {
               Flight::json([
                   'message' => 'User logged in successfully',
                   'data' => $response['data']
               ]);
           } else {
               Flight::halt(500, $response['error']);
           }
       } catch (Exception $e) {
           Flight::halt(500, "Login failed: " . $e->getMessage());
       }
   });
});
?>
