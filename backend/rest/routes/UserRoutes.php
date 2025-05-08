<?php

require_once __DIR__ . '/../services/UserService.class.php';

Flight::set('userService', new UserService());

Flight::group('/users', function() {

    /**
     * @OA\Get(
     *      path="/users",
     *      tags={"users"},
     *      summary="Get all users",
     *      @OA\Response(
     *           response=200,
     *           description="Get all users"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('userService')->getUsers();
        Flight::json(["data" => $data]);
    });

    /**
     * @OA\Get(
     *      path="/users/{user_id}",
     *      tags={"users"},
     *      summary="Get user by ID",
     *      @OA\Response(
     *           response=200,
     *           description="User data, or false if user does not exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="user_id", example="1", description="User ID")
     * )
     */
    Flight::route('GET /@user_id', function($user_id) {
        $user = Flight::get('userService')->getUserByID($user_id);
        Flight::json($user, 200);
    });

    /**
     * @OA\Post(
     *      path="/users",
     *      tags={"users"},
     *      summary="Add or update a user",
     *      @OA\Response(
     *           response=200,
     *           description="User data, or exception if user is not added properly"
     *      ),
     *      @OA\RequestBody(
     *          description="User data payload",
     *          @OA\JsonContent(
     *              required={"name", "email", "password", "role"},
     *              @OA\Property(property="id", type="integer", example="1", description="User ID"),
     *              @OA\Property(property="name", type="string", example="John Doe", description="User name"),
     *              @OA\Property(property="email", type="string", example="john.doe@example.com", description="User email"),
     *              @OA\Property(property="password", type="string", example="password123", description="User password"),
     *              @OA\Property(property="role", type="string", example="admin", description="User role")
     *          )
     *      )
     * )
     */
    Flight::route('POST /', function() {
        $payload = Flight::request()->data->getData();

        if (isset($payload['id']) && !empty($payload['id'])) {
            $user = Flight::get('userService')->editUser($payload);
        } else {
            unset($payload['id']);
            $user = Flight::get('userService')->addUser($payload);
        }

        Flight::json(['message' => "User successfully saved.", 'data' => $user]);
    });

    /**
     * @OA\Put(
     *      path="/users/{user_id}",
     *      tags={"users"},
     *      summary="Edit user by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Updated user data"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="User ID"),
     *      @OA\RequestBody(
     *          description="User data payload",
     *          @OA\JsonContent(
     *              required={"name", "email", "role"},
     *              @OA\Property(property="name", type="string", example="John Doe", description="User name"),
     *              @OA\Property(property="email", type="string", example="john.doe@example.com", description="User email"),
     *              @OA\Property(property="role", type="string", example="admin", description="User role")
     *          )
     *      )
     * )
     */
    Flight::route('PUT /@user_id', function($user_id) {
        $payload = Flight::request()->data->getData();
        $payload['id'] = $user_id;

        $user = Flight::get('userService')->editUser($payload);
        Flight::json(['message' => "User successfully updated.", 'data' => $user]);
    });

    /**
     * @OA\Delete(
     *      path="/users/{user_id}",
     *      tags={"users"},
     *      summary="Delete user by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Deleted user data or 500 status code exception otherwise"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="user_id", example="1", description="User ID")
     * )
     */
    Flight::route('DELETE /@user_id', function($user_id) {
        if (empty($user_id)) {
            Flight::halt(500, "You must provide a valid user ID!");
        }

        Flight::get('userService')->deleteUser($user_id);
        Flight::json(['message' => "User successfully deleted."]);
    });

});

?>