<?php

require_once __DIR__ . '/../services/ReviewsService.class.php';

Flight::set('reviewsService', new ReviewsService());

Flight::group('/reviews', function() {

    /**
     * @OA\Get(
     *      path="/reviews",
     *      tags={"reviews"},
     *      summary="Get all reviews",
     *      @OA\Response(
     *           response=200,
     *           description="Get all reviews"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('reviewsService')->getReviews();
        Flight::json(["data" => $data]);
    });

    /**
     * @OA\Get(
     *      path="/reviews/{review_id}",
     *      tags={"reviews"},
     *      summary="Get review by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Review data, or false if review does not exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="review_id", example="1", description="Review ID")
     * )
     */
    Flight::route('GET /@review_id', function($review_id) {
        $review = Flight::get('reviewsService')->getReviewByID($review_id);
        Flight::json($review, 200);
    });

    /**
     * @OA\Post(
     *      path="/reviews",
     *      tags={"reviews"},
     *      summary="Add or update a review",
     *      @OA\Response(
     *           response=200,
     *           description="Review data, or exception if review is not added properly"
     *      ),
     *      @OA\RequestBody(
     *          description="Review data payload",
     *          @OA\JsonContent(
     *              required={"rating", "review_text"},
     *              @OA\Property(property="id", type="integer", example="1", description="Review ID"),
     *              @OA\Property(property="rating", type="integer", example="5", description="Rating"),
     *              @OA\Property(property="review_text", type="string", example="Great course!", description="Review text")
     *          )
     *      )
     * )
     */
    Flight::route('POST /', function() {
        $payload = Flight::request()->data->getData();

        if (isset($payload['id']) && !empty($payload['id'])) {
            $review = Flight::get('reviewsService')->editReview($payload);
        } else {
            unset($payload['id']);
            $review = Flight::get('reviewsService')->addReview($payload);
        }

        Flight::json(['message' => "Review successfully saved.", 'data' => $review]);
    });

    /**
     * @OA\Put(
     *      path="/reviews/{review_id}",
     *      tags={"reviews"},
     *      summary="Edit review by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Updated review data"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="review_id", example="1", description="Review ID"),
     *      @OA\RequestBody(
     *          description="Review data payload",
     *          @OA\JsonContent(
     *              required={"rating", "review_text"},
     *              @OA\Property(property="rating", type="integer", example="5", description="Rating"),
     *              @OA\Property(property="review_text", type="string", example="Great course!", description="Review text")
     *          )
     *      )
     * )
     */
    Flight::route('PUT /@review_id', function($review_id) {
        $payload = Flight::request()->data->getData();
        $payload['id'] = $review_id;

        $review = Flight::get('reviewsService')->editReview($payload);
        Flight::json(['message' => "Review successfully updated.", 'data' => $review]);
    });

    /**
     * @OA\Delete(
     *      path="/reviews/{review_id}",
     *      tags={"reviews"},
     *      summary="Delete review by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Deleted review data or 500 status code exception otherwise"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="review_id", example="1", description="Review ID")
     * )
     */
    Flight::route('DELETE /@review_id', function($review_id) {
        if (empty($review_id)) {
            Flight::halt(500, "You must provide a valid review ID!");
        }

        Flight::get('reviewsService')->deleteReview($review_id);
        Flight::json(['message' => "Review successfully deleted."]);
    });

});

?>