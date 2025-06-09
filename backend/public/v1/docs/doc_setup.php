<?php
/**
* @OA\Info(
*     title="API",
*     description="Educos API",
*     version="1.0",
*     @OA\Contact(
*         email="educos@gmail.com",
*         name="Educos"
*     )
* )
*/
/**
* @OA\Server(
*     url= "http://localhost/web-project/backend",
*     description="Educos API server (XAMPP - Primary)"
* )
*/
/**
* @OA\Server(
*     url= "http://localhost:8000",
*     description="Educos API server (Development)"
* )
*/
/**
* @OA\SecurityScheme(
*     securityScheme="ApiKey",
*     type="apiKey",
*     in="header",
*     name="Authentication"
* )
*/
