<?php

require_once __DIR__ . '/../services/CategoriesService.class.php';

Flight::set('categoriesService', new CategoriesService());

Flight::group('/categories', function() {

    /**
     * @OA\Get(
     *      path="/categories",
     *      tags={"categories"},
     *      summary="Get all categories",
     *      @OA\Response(
     *           response=200,
     *           description="Get all categories"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('categoriesService')->getCategories();
        Flight::json(["data" => $data]);
    });

    /**
     * @OA\Get(
     *      path="/categories/{category_id}",
     *      tags={"categories"},
     *      summary="Get category by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Category data, or false if category does not exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="category_id", example="1", description="Category ID")
     * )
     */
    Flight::route('GET /@category_id', function($category_id) {
        $category = Flight::get('categoriesService')->getCategoryByID($category_id);
        Flight::json($category, 200);
    });

    /**
     * @OA\Post(
     *      path="/categories",
     *      tags={"categories"},
     *      summary="Add or update a category",
     *      @OA\Response(
     *           response=200,
     *           description="Category data, or exception if category is not added properly"
     *      ),
     *      @OA\RequestBody(
     *          description="Category data payload",
     *          @OA\JsonContent(
     *              required={"name", "number_of_courses", "image_url", "description"},
     *              @OA\Property(property="id", type="integer", example="1", description="Category ID"),
     *              @OA\Property(property="name", type="string", example="Programming", description="Category name"),
     *              @OA\Property(property="number_of_courses", type="integer", example="10", description="Number of courses in the category"),
     *              @OA\Property(property="image_url", type="string", example="http://example.com/image.jpg", description="Category image URL"),
     *              @OA\Property(property="description", type="string", example="Courses related to programming.", description="Category description")
     *          )
     *      )
     * )
     */
    Flight::route('POST /', function() {
        $payload = Flight::request()->data->getData();

        if (isset($payload['id']) && !empty($payload['id'])) {
            $category = Flight::get('categoriesService')->editCategory($payload);
        } else {
            unset($payload['id']);
            $category = Flight::get('categoriesService')->addCategory($payload);
        }

        Flight::json(['message' => "Category successfully saved.", 'data' => $category]);
    });

    /**
     * @OA\Put(
     *      path="/categories/{category_id}",
     *      tags={"categories"},
     *      summary="Edit category by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Updated category data"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="category_id", example="1", description="Category ID"),
     *      @OA\RequestBody(
     *          description="Category data payload",
     *          @OA\JsonContent(
     *              required={"name", "number_of_courses", "image_url", "description"},
     *              @OA\Property(property="name", type="string", example="Programming", description="Category name"),
     *              @OA\Property(property="number_of_courses", type="integer", example="10", description="Number of courses in the category"),
     *              @OA\Property(property="image_url", type="string", example="http://example.com/image.jpg", description="Category image URL"),
     *              @OA\Property(property="description", type="string", example="Courses related to programming.", description="Category description")
     *          )
     *      )
     * )
     */
    Flight::route('PUT /@category_id', function($category_id) {
        $payload = Flight::request()->data->getData();
        $payload['id'] = $category_id;

        $category = Flight::get('categoriesService')->editCategory($payload);
        Flight::json(['message' => "Category successfully updated.", 'data' => $category]);
    });

    /**
     * @OA\Delete(
     *      path="/categories/{category_id}",
     *      tags={"categories"},
     *      summary="Delete category by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Deleted category data or 500 status code exception otherwise"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="category_id", example="1", description="Category ID")
     * )
     */
    Flight::route('DELETE /@category_id', function($category_id) {
        if (empty($category_id)) {
            Flight::halt(500, "You must provide a valid category ID!");
        }

        Flight::get('categoriesService')->deleteCategory($category_id);
        Flight::json(['message' => "Category successfully deleted."]);
    });

});

?>